<?php
// $Id$

/**
 * @file
 * Search functions for the 'Answers' module
 * 
 * @author Chip Cleary
 * 
 */

 /* 
  * The module provides two key functions
  *    1. A search view for searching for questions
  *    2. A workflow for asking new questions which requires the user to first review similar questions before posting
  *
  * Function 1: A search view for searching for questions
  *   1. A user can start a search by using the path "questions/search?keys=<keys>"
  *   2. An exposed views form catches this routing
  *   2. The user is shown a list of matching questions. 
  *     - The display is provided using a list view like that used in the rest of Answers (e,g, the path "questions/all")
  *     - The display adds a link to allow users to create a new question if desired.  
  *   3. The user can view one of the questions, ask a new question, or modify the search
  * 
  * Function 2: A workflow for asking new questions which requires the user to review similar questions
  *
  *   1. A user can start to ask a question at 'questions/start_ask'
  *   2. The function answers_menu catches this path and calls the 'answers_search_start_ask' function
  *   3. This function provides a simple search form. It allows the user to enter a question
  *   4. This question is then passed to 'questions/continue_ask?keys=<question>
  *   5. An exposed views form catches this routing and shows matching questions
  *   6. The user can view one of the questions, modify his question, or go on to ask his question
  *   7. If the user goes on, the question is passed to 'node/add/question?title=<question>'
  *   8. The function answers_form_alter is called and inserts the title into the form
  */

function answers_start_ask_form($form, &$form_state) {

  $form['question'] = array(
    '#type'  => 'textfield',
    '#title' => 'Question',
    '#size'  => 80,
  );

  $form['submit'] = array(
    '#type'   => 'submit',
    '#value'  => t('Begin'),
    '#submit' => array('answers_start_ask_submit'),
  );

  return $form;
}

function answers_start_ask_submit($form, &$form_state) {
  $question = check_plain($form_state['values']['question']);
  $form_state['redirect'] = array(
    'questions/continue_ask',
    array('query' => array('keys' => $question)),
  );
}

/**
 * Pseudo implementation of hook_form_alter()
 *
 * Note: This is an include file, not a separate module. So, the normal hook mechanism does not
 * call '_answers_search_form_alter'. Rather it is called manually from within 'answers_form_alter'.
 */

function _answers_search_form_alter(&$form, &$form_state, $form_id) {

  switch ($form_id) {

    case 'views_exposed_form':
 
      if (($form['#action'] == '/questions/search') ||
         ($form['#action'] == '/questions/continue_ask'))  {

        // Delete the title from the search box
        $form['#info']['filter-keys']['label'] = '';

        // Change the length & description of the search box
        $form['keys']['#title'] = 'Question';
        $form['keys']['#size'] = 80;
        $form['keys']['#attributes']['title'] = t('Enter your question');

        // Change the title of the standard search button
        $form['submit']['#value'] = t('Search');

      }

      // If appropriate, add a button for posting the question
      if ($form['#action'] == '/questions/continue_ask') {
        $form['submit']['#value'] = t('Search Again');
        $form['continue_ask'] = array(
          '#type'   => 'submit',
          '#name'   => 'test',
          '#value'  => t('Continue With Your Question'),
          '#submit' => array('answers_continue_ask_submit'),
        );
      }
    break;
  }
}

function answers_continue_ask_submit($form, &$form_state) {
  $form_state['no_redirect'] = FALSE;
  $title = check_plain($form_state['input']['keys']);
  $form_state['redirect'] = array(
    'node/add/question',
    array('query' => array('title' => $title)),
  );
}

