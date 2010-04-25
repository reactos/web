<?php
/**
 * Bugzilla Query Renderer
 */

/**
 * Copyright (C) 2008 - Ian Homer & bemoko
 *
 * This program is free software; you can redistribute it and/or modify it 
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) 
 * any later version.
 *
 * This program is distributed in the hope that it will be useful, but 
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY 
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for    
 * more details.
 * 
 * You should have received a copy of the GNU General Public License along 
 * with this program; if not, see <http://www.gnu.org/licenses>.
 */

class BugzillaQueryRenderer {
  var $query;
  var $context;
  var $connector;
  var $output;
  
  public function BugzillaQueryRenderer($query) {
    $this->query=$query;
    $this->context=$query->context;
    $this->connector=$query->connector;
  }
  
  /**
   * Render query record set
   *
   * @param recordset
   * @return rendered markup
   */
  public function renderHTML($result) {
    $this->output = "";
    $nRows=$this->connector->getRowCount($result);
    
    $this->context->debug &&
      $this->context
        ->debug("Rendering report : rows = $nRows");

    if ($this->query->get('heading')) {
      $this->output.="<h1>".$this->query->get('heading')."</h1>";
    }
    # Table start
    if ($this->query->get('format') != "inline") {
        $this->output .= "<table class=\"bugzilla";
      if ($this->query->is('sortable')) {
        $this->output.=" sortable";
      }
      if ($this->query->get('bar')) {
        $this->output.=" bz_bar";
      }
      $this->output.="\">";
    } else {
      
    }
    # Initialise details row logic
    $detailsRowColumns=array();
    $arrayOfDetailRowColumns=explode(",",$this->query->get('detailsrow'));
    foreach ($arrayOfDetailRowColumns as $detailRowColumn) {
      $detailsRowColumns[$detailRowColumn]=1;
    }
    $this->numberOfMainRowColumns=0;
    if ($this->query->get('bar')) {
      $this->numberOfMainRowColumns=2;
    } else {
      foreach ($this->query->getColumns() as $column) {
        if (!array_key_exists($column,$detailsRowColumns)) {
          $this->numberOfMainRowColumns++;
        }
      }
    }
    
    # Initialise total logic
    $arrayOfTotalColumns;
    $arrayOfTotals;
    if ($this->query->get('total')) {
      $arrayOfTotalColumns=explode(",",$this->query->get('total')); 
      $arrayOfTotals=array();   
      foreach ($arrayOfTotalColumns as $totalColumn) {
        $arrayOfTotals[$totalColumn]=0;
      }
    }
      
    # Display table header
    if ($this->query->get('headers')=="show" || (!$this->query->get('bar') && 
        $this->query->get('format')=='table' &&
        $this->query->get('headers')!="hide" &&
        !$this->query->explitlyOneValue)) {
        $this->output .= "<tr>";
      foreach ($this->query->getColumns() as $column) {
        $name=trim($column);
        if (array_key_exists($column,$this->query->columnName)) {
          $name=$this->query->columnName[$column];
        }
        $title;
        
        if (array_key_exists($column,$this->query->columnLabelName)) {
          $title=$this->query->columnLabelName[$column];
        } else {
          $title=$name;
        }
        $this->context->debug && 
          $this->context->debug("Name for column $column is $name");  
        if (($column=="summary") && ($nRows > 1)) {
          $name.=" ($nRows tasks)";
          if ($this->context->bzserver && $this->query->get('bzurl')=="show") {
            if ($this->context->rawHTML) {
              $name.=" <a href=\"".$this->bzURL."\">&rArr;</a>";
            } else {
              $name.=" [".$this->query->bzURL." &rArr;]";
            }
          }
        }     
            $this->output .= "<th title=\"$title\"><b>$name</b></th>";
        }
        $this->output .= "</tr>";
    }

      # Create Table Data Rows
    $even=true;
    $count=0;
    $localMaxRows=$this->query->getMaxRows();
    $localMaxRowsForBarChart=$this->query->getMaxRowsForBarChart();
    $groupValue=array();
    $groupTotal=array();
    $groups;
    $doGrouping=0;
    if ($this->query->getGroup()) {
      $doGrouping=1;
      $groups=split(",",$this->query->getGroup());
      #
      # Prepare group counters
      #
      foreach ($groups as $group) {
        array_push($groupValue,"");
        array_push($groupTotal,0);
      }
    }
    $barArray=$this->getBarArray();
    $currentId=0;
    $currentBlocksId=0;
    $currentDependsId=0;
    while ($line = $this->connector->fetch($result)) {
      #
      # Add group heading
      #
      if ($doGrouping) {
        $iGroup=0;
        foreach ($groups as $group) {         
          $groupTotal[$iGroup]++;
          $newGroupValue=$this->query->formatForHeading(
            $line[$this->query->mapField(
              $group)],$group);
          if ($newGroupValue != $groupValue[$iGroup]) {
            $colspan=$this->numberOfMainRowColumns;
            if ($this->query->get('bar')) {
              if ($groupValue[$iGroup]) {
                $this->renderBar($barArray);
                foreach (array_keys($barArray) as $key) {
                  $barArray[$key]=0;
                }
              }
              $colspan-=1;
            }
            if ($this->query->get('total') && $groupValue) {
              $this->renderTotal($arrayOfTotals,1);         
              foreach ($arrayOfTotalColumns as $totalColumn) {
                $arrayOfTotals[$totalColumn]=0;
              }
            }
            $groupValue[$iGroup]=$newGroupValue;
            $this->output.="<tr class=\"bz_group bz_group_$iGroup\"><td colspan=\""
              .$colspan.
              "\">".$groupValue[$iGroup].
              "</td>";
            if ($this->query->get('bar')) {
              $this->output.="<td class=\"total\">&nbsp;</td>";
            }
            $this->output.="</tr>";
            $groupTotal[$iGroup]=0;
            break;
          }
          $iGroup++;
        }
      }
      ++$count;

      # Safety check break out of loop if there's too much.  Only
      # display warning if max rows has not come the function call, i.e.
      # user has explicitly truncated
      if ($count > $localMaxRows) {
        if ($localMaxRows > $this->query->get('maxrows')) {
          $this->context->
            warn("Report truncated - count greater than ".
              "max allowed ".
              "$count > $localMaxRows");
        }
        break;
      }
      #
      # Only render the row if the ID has changed from previous row
      # to support LEFT JOINS
      #
    if ($line["id"] != $currentId) {
      $this->context->debug &&
        $this->context
          ->debug("Rendering rows $count/$nRows : id =".
            $line["id"]);

      # Bar counter
      if ($this->query->get('bar')) {
        if ($count > $localMaxRowsForBarChart) {
          $this->context->warn("Bar count greater than max allowed ".
            "$count > $localMaxRowsForBarChart");
          break;
        }
        $barValue=$line[$this->query->mapField($this->query->get('bar'))];
        if (array_key_exists($barValue,$barArray)) {
          $barArray[$barValue]+=1;
        } else {
          $barArray[$barValue]=1;
        }
        continue;
      }
      
      # Total counter
      if ($this->query->get('total')) {
        foreach ($arrayOfTotalColumns as $totalColumn) {
          $value=$line[$this->query->mapField($totalColumn)];
          if (is_numeric($value)) {
            $arrayOfTotals[$totalColumn]+=$value;
          } else {
            $arrayOfTotals[$totalColumn]+=1;
          }
        }       
      }

      $currentId=$line["id"];
      $firstcolumn=true;
      $even=!$even;
      $class="bz_bug ".$line["priority"]." ".$line["severity"]." ".$line["status"]." ";
      if ($even) {
        $class.="bz_row_even";
      } else {
        $class.="bz_row_odd";
      }
      #
      # Formatting for inline and list
      #
      if (!$this->query->get('hide')) {
        if ($this->query->get('format') == "list" || $this->query->get('format') == "inline") {
          if ($this->query->get('format') == "list") {
            $this->output .= "<tr class=\"".$class."\">";         
            $this->output.="<td class=\"bz_list\" colspan=\"".
              $this->numberOfMainRowColumns."\">";
          } else {
            $this->output .= "<span>";
            if ($count > 1) {
              $this->output .= ", ";            
            }
          }
          if (array_key_exists("to",$this->query->getColumns())) {    
            $this->output.=
              "[".$this->query->
                format($line[$this->query->mapField('to')],
                'to',"")."] ";
          }
          if (array_key_exists("deadline",$this->query->getColumns())) {
            $deadline=$line[$this->query->mapField('deadline')];
            if ($deadline) {
              $this->output.=
                "(".$this->query->format($deadline,"deadline","").
                ") ";
            }
          }
          $this->output.=           
            $this->query->
              format($this->query->getDBValue($line,
                $this->query->mapField('summary')),
              'summary',"")." (#".
            $this->query->
              format($line[$this->query->mapField('id')],
              'id',"").")";
          if ($this->query->get('format') == "list") {
            $this->output .= "</td></tr>";
          } else {
            $this->output.="</span>";
          }
        #
        # Default formatting
        #
        } else {
            $this->output .= "<tr class=\"".$class."\">";
          foreach ($this->query->getColumns() as $column) {
            $dbColumn=$this->query->mapField($column);
            if (!$this->query->get('detailsrow') 
                or !array_key_exists($dbColumn,
                  $detailsRowColumns)) {
              $title=$this->query->getValueTitle($line,$dbColumn);
              $value=$this->query->
                format($this->query->getDBValue($line,$dbColumn),$column,$title);
              $this->output.="<td";
              if ($title) {
                $this->output.=" title=\"$title\"";
              }
              $this->output.=">$value";
              if ($firstcolumn) {
                $firstcolumn=false;
                /**
                 * Start with a carriage return so that comments starting with 
                 * list characters, e.g. *, # render in wiki style
                 */
                if ($this->query->get('lastcomment') or $this->query->get('keywords')) {
                  $lastcomment="";
                  $keywords="";
                  if ($this->query->get('lastcomment')) {
                    $lastcomment=trim($this->query->getDBValue($line,"thetext"));                   
                  }
                  if ($this->query->isRequired("keywords")) {
                    $keywords=$this->query->
                      format($line[$this->query->mapField("keywords")],
                        "keywords","");
                  }
                  if (strlen($lastcomment) > 0 or strlen($keywords) > 0) {
                    $this->output.=
                      "*<div class=\"bz_comment\">";
                    if ($keywords) {
                      $this->output.="<span class=\"bz_keyword\">$keywords</span>";
                    }
                    $this->output.=
                      "<span class=\"bug_id\">".
                      $line["id"].
                      "</span>\n".
                      $this->makeWikiSafe($lastcomment).
                      "</div>";
                  }
                }
                #
                # Render quick flag
                #
                if ($this->query->isRequired('quickflag')) {
                  if ($line["flagdate"]) {
                    $this->output.="<span class=\"flag\" title=\"Flag : ".
                      $line["flagdate"]."\">?</span>";
                  }
                }
              }         
              $this->output.="</td>";
            }
          }
          $this->output .= "</tr>";
        }
      }
    } 
      if ($this->query->get('detailsrow')) {
        $this->renderDetailsRow($detailsRowColumns,$line,
          $this->query->get('detailsrowprepend'));
      }
      #
      # We have LEFT JOIN so we need to ignore repeats
      #
      if ($this->query->get('blocks') && 
          ($line["blocks"] != $currentBlocksId)) {
        $currentBlocksId=$line["blocks"];     
        $this->renderDetailsRow(
        $this->query->blocksRowColumns,$line,"&rArr; ");
      }
      #
      # We have LEFT JOIN so we need to ignore repeats
      #
      if ($this->query->get('depends') && 
          ($line["depends"] != $currentDependsId)) {
        $currentDependsId=$line["depends"];     
        $this->renderDetailsRow(
        $this->query->dependsRowColumns,$line,"&lArr; ");
      }
    }

    # Total counter
    if ($this->query->get('total')) {
      $this->renderTotal($arrayOfTotals);
    }
      
    #
    # Display bar
    #
    if ($this->query->get('bar')) {
      $this->renderBar($barArray);
      $this->output.="<tr class=\"bz_bar_total\"><td colspan=\""
        .($this->numberOfMainRowColumns-1).
        "\">total</td><td class=\"total\">$nRows</td></tr>";      
    }
    
      # Table end
    if ($this->query->get('format') != "inline") {
        $this->output .= "</table>";
    }

    return $this->output;
  }
  
  #
  # Render a details row
  #
  private function renderDetailsRow($array,$line,$prepend) {
    $details="";
    $extra="";
    $title="";
    foreach (array_keys($array) as $column) {
      $dbColumn=$this->query->mapField($column);
      if ($line[$column]) {
        $valueTitle=$this->query->getValueTitle($line,$column);
        if ($valueTitle) {
          $this->context->debug &&
            $this->context
              ->debug("Setting title for $column to $valueTitle");
        }
        switch ($array[$column]) {
          case "title" :
            $title.=$this
              ->query->format($this->query->getDBValue($line,$dbColumn),
                $column,$valueTitle)." ";
            break;
          case "extra" :
            $extra.=$this
              ->query->format($this->query->getDBValue($line,$dbColumn),
                $column,$valueTitle)." ";
            break;
          default :
            $details.=$this
              ->query->format($this->query->getDBValue($line,$dbColumn),
                $column,$valueTitle)." ";
        }
      }
    } 
    if (trim($details)) {
      #
      # Use the trick in http://meta.wikimedia.org/wiki/Help:Sorting to allow the table
      # to be sorted
      #
      $this->output.="<tr class=\"bz_details\">";
      $i=0;
      foreach ($this->query->getColumns() as $column) {
        $dbColumn=$this->query->mapField($column);        
        if (!$this->query->get('detailsrow') 
            or !array_key_exists($dbColumn,
              $detailsRowColumns)) {
          $title=$this->query->getValueTitle($line,$dbColumn);
          $value=$this->query->
            format($this->query->getDBValue($line,$dbColumn),$column,$title);
          #
          # Putting ZZZ after the value ensures that it sorts after the row this is associated with
          $this->output.="<td><span style=\"display:none\">$value</span>";
          if ($i==0) {
            #
            # Don't close for the last column since we're going to append the details 
            #
            $estimatedWidth=30 + $this->numberOfMainRowColumns * 5;
            $this->output.="<div title=\"$title\" class=\"bz_details\" style=\"margin-left:2em;margin-right:-".$estimatedWidth."em;overflow:auto\">";
            $this->output.=$prepend.$details;
            if ($extra) {
              $this->output.="<span class=\"bz_extra\"> - $extra</span>";
            }
            $this->output.="</div>";
          }
          $this->output.="</td>";
          $i++;
        }
      }
      $this->output.="</tr>";
    }   
  }
  
  # Render the totals summary. 
  private function renderTotal($arrayOfTotals) {
    if ($this->query->get('format') != "inline") $this->output .= "<tr class=\"bz_total\">";
    $first=true;
    foreach ($this->query->getColumns() as $column) {
      if ($this->query->get('format') != "inline") {
        $this->output.="<td>";
      } 
      if (array_key_exists($column,$arrayOfTotals)) {
        if ($this->query->get('format') == "inline") {
          if ($first) {
            $first=false;
          } else {
            $this->output.=", ";
          }
        }
        $this->context->debug &&
          $this->context->debug("Writing $column total = ".
          $arrayOfTotals[$column]); 
        $this->output.=$arrayOfTotals[$column];
      } else {
        if ($this->query->get('format') != "inline") $this->output.="&nbsp;";
      }
      if ($this->query->get('format') != "inline") $this->output.="</td>";
    }
    if ($this->query->get('format') != "inline") $this->output.="</tr>";   
  }

  private function renderBar($barArray) {
    $total=0;
    $nonZeroKeyCount=0;
    $arrayKeys=array_keys($barArray);     
    foreach ($arrayKeys as $key) {
      $total+=$barArray[$key];
      $barArray[$key]>0 && $nonZeroKeyCount++;
    }
    $classColourCode="few";     
    $keyCount=count($arrayKeys);
    if ($keyCount > 6) {
      $classColourCode="some";
    } else if ($keyCount > 10) {
      $classColourCode="many";          
    }
    $this->output.="<tr class=\"bz_bar $classColourCode\"><td colspan=\""
      .($this->numberOfMainRowColumns-1).
      "\">";
    $i=0;
    $iNonZero=0;
    sort($arrayKeys);
    $rowTotal=0;
    $rowWidthTotal=0;
    foreach ($arrayKeys as $key) {
      $count=$barArray[$key];
      $i++;
      if ($count > 0) {
        $iNonZero++;
        $widthString="";
        $rowTotal+=$count;
        if ($iNonZero==$nonZeroKeyCount) {
          $class="C$i last";
          # Make sure we don't get caught by rounding error
          $width=100-$rowWidthTotal;  
        } else {
          $width=number_format((100*$count)/$total,0);
          $rowWidthTotal+=$width;
          $class="C$i notlast";
        }
        $content;
        if (strlen($key) > ($width /2) ) {
          $content="&nbsp;";
        } else {
          $keyAndCount="$key ($count)";
          if (strlen($keyAndCount) < ($width /2) ) {
            $content=$keyAndCount;
          } else {
            $content=$key;        
          }
        }
        $widthString=" style=\"width:".$width."%\"";            
        $this->output.="<div title=\"$key = $count";
        if ($this->context->debug) {
          $this->output.="class=$class / width=$width /  key count=$keyCount / nz key count=$nonZeroKeyCount / i=$i / inz=$iNonZero";
        }
        $this->output.=
          "\"$widthString class=\"$class\"><div>".
          "$content</div></div>";
      }
    } 
    $this->output.="</td><td class=\"total\">$rowTotal</td></tr>";
  }

  /**
   * Render output for no results
   */ 
  public function renderNoResultsHTML() {
    if ($this->query->get('noresultsmessage')) {
      return "<div class=\"bz_noresults\">".
        $this->query->get('noresultsmessage')."</div>";
    } else {
      return "";
    }
  }
  
  
  #
  # Initialise the bar array
  #
  private function getBarArray() {
    $barArray=array();
    if (array_key_exists($this->query->get('bar'),
        $this->query->fieldValues)) {
      foreach (split(",",
          $this->query->
            fieldValues[$this->query->get('bar')]) as $key) {
        $barArray[$key]=0;
      }
      $this->context->debug &&
        $this->context->debug("Initialised bar keys (".
          $this->query->get('bar')."): ".
          join(",",array_keys($barArray)));
    }
    return $barArray;
  }
  
  #
  # Make markup safe for inclusion in 
  #
  # (1) Append a "." at the end of wiki style headings so that the markup
  # does not get interpreted as wiki headings and get included in the TOC
  # See issue [#22]
  #
  private function makeWikiSafe($s) {
    $s=htmlspecialchars($s);
    if (strpos($s,"=") > -1) {
      $s=preg_replace('/^([=]+)[[:space:]]*$/m','<br/>$1<br/>',$s);
      # Bit cheating here because I don't make sure the closing equals match
      # the starting equals, but it's good enough
      $s=preg_replace('/^([=]+)([^=]*)=+[[:space:]]*$/m','$1$2$1.<br/>',$s);
    }
    return $s;
  }
}
?>
