<?php
/**
*
* This program is the full and free Spanish (of Spain) phpBB 3.0 Translation.
* Copyright (c) 2007 Huan Manwe for phpbb-es.com
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License along
* with this program; if not, write to the Free Software Foundation, Inc.,
* 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*
**/

/**
*
* search_synonyms [Spanish [Es]]
*
* @package language
* @copyright (c) 2010 phpBB Group. Modified by Huan Manwe for phpbb-es.com in 2010
* @author 2010-10-20 - Traducido por Huan Manwe junto con phpbb-es.com (http://www.phpbb-es.com).
* @author - ImagePack made by Xoom (webmaster of http://www.muchografico.com and colaborator of http://www.phpbb-es.com)
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License
*
*/
// NOTE
// merlin: commented section is just for sample. delete if obsolete.
//	   add elements to array as you whish
//

if (!defined('IN_PHPBB'))
{
	exit;
}


$synonyms = array(
	'aunar'		=> 'juntar',
	'a ver'		=> 'vamos a ver',
	'birra'		=> 'cerveza',	
	'coche'		=> 'automóvil',
	'jodido'	=> 'fastidiado',
	'meter'		=> 'insertar',
	'correctamente'	=> 'con éxito',

);
/*
$synonyms = array(
	'abcense'			=> 'absence',
	'abridgement'		=> 'abridgment',
	'accomodate'		=> 'accommodate',
	'acknowledgment'	=> 'acknowledgement',
	'airplane'			=> 'aeroplane',
	'allright'			=> 'alright ',
	'andy'				=> 'andrew',
	'anemia'			=> 'anaemia',
	'anemic'			=> 'anaemic',
	'anesthesia'		=> 'anaesthesia',
	'apologize'			=> 'apologise',
	'archean'			=> 'archaean',
	'archeology'		=> 'archaeology',
	'archeozoic'		=> 'archaeozoic',
	'armor'				=> 'armour',
	'artic'				=> 'arctic',
	'attachment'		=> 'attachement',
	'attendence'		=> 'attendance',

	'barbecue'	=> 'barbeque',
	'behavior'	=> 'behaviour',
	'biassed'	=> 'biased',
	'biol'		=> 'biology',
	'buletin'	=> 'bulletin',

	'calender'	=> 'calendar',
	'canceled'	=> 'cancelled',
	'car'		=> 'automobile',
	'catalog'	=> 'catalogue',
	'cenozoic'	=> 'caenozoic',
	'center'	=> 'centre',
	'check'		=> 'cheque',
	'color'		=> 'colour',
	'comission'	=> 'commission',
	'comittee'	=> 'committee',
	'commitee'	=> 'committee',
	'conceed'	=> 'concede',
	'creating'	=> 'createing',
	'curiculum'	=> 'curriculum',

	'defense'		=> 'defence',
	'develope'		=> 'develop',
	'discription'	=> 'description',
	'dulness'		=> 'dullness',

	'encyclopedia'	=> 'encyclopaedia',
	'enroll'		=> 'enrol',
	'esthetic'		=> 'aesthetic',
	'etiology'		=> 'aetiology',
	'exhorbitant'	=> 'exorbitant',
	'exhuberant'	=> 'exuberant',
	'existance'		=> 'existence',

	'favorite'		=> 'favourite',
	'fetus'			=> 'foetus',
	'ficticious'	=> 'fictitious',
	'flavor'		=> 'flavour',
	'flourescent'	=> 'fluorescent',
	'foriegn'		=> 'foreign',
	'fourty'		=> 'forty',

	'gage'			=> 'guage',
	'geneology'		=> 'genealogy',
	'grammer'		=> 'grammar',
	'gray'			=> 'grey',
	'guerilla'		=> 'guerrilla',
	'gynecology'	=> 'gynaecology',

	'harbor'		=> 'harbour',
	'heighth'		=> 'height',
	'hemaglobin'	=> 'haemaglobin',
	'hematin'		=> 'haematin',
	'hematite'		=> 'haematite',
	'hematology'	=> 'haematology',
	'honor'			=> 'honour',

	'innoculate'	=> 'inoculate',
	'installment'	=> 'instalment',
	'irrelevent'	=> 'irrelevant',
	'irrevelant'	=> 'irrelevant',

	'jeweler'	=> 'jeweller',
	'judgement'	=> 'judgment',

	'labeled'	=> 'labelled',
	'labor'		=> 'labour',
	'laborer'	=> 'labourer',
	'laborers'	=> 'labourers',
	'laboring'	=> 'labouring',
	'licence'	=> 'license',
	'liesure'	=> 'leisure',
	'liquify'	=> 'liquefy',

	'maintainance'	=> 'maintenance',
	'maintenence'	=> 'maintenance',
	'medieval'		=> 'mediaeval',
	'meter'			=> 'metre',
	'milage'		=> 'mileage',
	'millipede'		=> 'millepede',
	'miscelaneous'	=> 'miscellaneous',
	'morgage'		=> 'mortgage',

	'noticable'	=> 'noticeable',

	'occurence'	=> 'occurrence',
	'offense'	=> 'offence',
	'ommision'	=> 'omission',
	'ommission'	=> 'omission',
	'optimize'	=> 'optimize',
	'organise'	=> 'organize',

	'pajamas'			=> 'pyjamas',
	'paleography'		=> 'palaeography',
	'paleolithic'		=> 'palaeolithic',
	'paleontological'	=> 'palaeontological',
	'paleontologist'	=> 'palaeontologist',
	'paleontology'		=> 'palaeontology',
	'paleozoic'			=> 'palaeozoic',
	'pamplet'			=> 'pamphlet',
	'paralell'			=> 'parallel',
	'parl'				=> 'parliament',
	'parlt'				=> 'parliament',
	'pediatric'			=> 'paediatric',
	'pediatrician'		=> 'paediatrician',
	'pediatrics'		=> 'paediatrics',
	'pedodontia'		=> 'paedodontia',
	'pedodontics'		=> 'paedodontics',
	'personel'			=> 'personnel',
	'practise'			=> 'practice',
	'program'			=> 'programme',
	'psych'				=> 'psychology',

	'questionaire'	=> 'questionnaire',

	'rarify'		=> 'rarefy',
	'reccomend'		=> 'recommend',
	'recieve'		=> 'receive',
	'resistence'	=> 'resistance',
	'restaraunt'	=> 'restaurant',

	'savior'			=> 'saviour',
	'sep'				=> 'september',
	'seperate'			=> 'separate',
	'sept'				=> 'september',
	'sieze'				=> 'seize',
	'summarize'			=> 'summarise',
	'summerize'			=> 'summarise',
	'superceed'			=> 'supercede',
	'superintendant'	=> 'superintendent',
	'supersede'			=> 'supercede',
	'suprise'			=> 'surprise',
	'surprize'			=> 'surprise',
	'synchronise'		=> 'synchronize',

	'temperary'		=> 'temporary',
	'theater'		=> 'theatre',
	'threshhold'	=> 'threshold',
	'transfered'	=> 'transferred',
	'truely'		=> 'truly',
	'truley'		=> 'truly',

	'useable'	=> 'usable',

	'valor'	=> 'valour',
	'vigor'	=> 'vigour',
	'vol'	=> 'volume',

	'whack'		=> 'wack',
	'withold'	=> 'withhold',

	'yeild'	=> 'yield',
);
*/
?>