<?php
// $Id$

/**
 * @file
 * Notification functions for the 'Answers' module
 * 
 * @author Chip Cleary
 * 
 */

 /* 
  * The file provides notification functions
  *    1. Notify question authors when their questions are answered (if they have so requested)
  *
  */

/*
 * Add settings to the notification form
 */ 
function _answers_notify_settings() {
  $form = array();
  
  $form['answers_notification'] = array(
    '#type' => 'fieldset',
    '#title' => t('"New Answer" Notification Email'),
    '#description' => t('Users can ask to be notified by email when a new answer is posted to their question. Settings for the email.'),
  );

  $form['answers_notification']['answers_new_answer_notice_subject'] = array(
    '#type' => 'textfield',
    '#title' => t('Subject line'),
    '#default_value' => variable_get('answers_new_answer_notice_subject', ''),
    '#description' => t('Dynamic variables available: !question_user_name, !answer_user_name, !question_title, !question_url, and !site'),
    '#required' => TRUE
  );


  $form['answers_notification']['answers_new_answer_notice_body'] = array(
    '#type' => 'textarea',
    '#title' => t('Body'),
    '#default_value' => variable_get('answers_new_answer_notice_body', ''),
    '#description' => t('Dynamic variables available: !question_user_name, !answer_user_name, !question_title, !question_url, and !site.'),
    '#required' => TRUE
  );
  
  return $form;
}

/*
 * Pseudo implementation of hook_form_alter
 * (Note: This is not an actual hook but is instead called manually by answers_form_alter)
 *
 * If user is anonymous, hide the field allowing him/her to ask to be notified by email
 * This is a somewhat arduous way to do that based on http://drupal.org/node/208046
 */
function _answers_notify_form_alter(&$form, &$form_state, $form_id) {
  global $user;
  
  if ($form_id == 'question_node_form' && $user->uid == 0) { 
    $form['field_notify_p'][0]['#default_value']['value'] = 0;
    $form['field_notify_p']['#prefix'] = '<div style="display: none;">';
    $form['field_notify_p']['#suffix'] = '</div>';
  }
}


 /*
 * Pseudo implementation of hook_node_insert
 * (Note: This is not an actual hook but is instead called manually by answers_node_insert)
 *
/*
 * Implement hook__node_insert
 * Notify the question author if appropriate when a new answer is posted.
 */
function _answers_notify_node_insert($node) {
  if ($node->type=='answer') {
    $question_id = $node->field_answer_question['und'][0]['nid']; // extract the nid of the question
    if ($question_id) {
      answers_notify_new_answer($question_id);
    }
  }
}

/*
 * If the question author should be notified, do so
 */
function answers_notify_new_answer($nid) {
  global $user;
  
  $question = node_load($nid);
  $notify_p = $question->field_notify_p['und'][0]['value']; // extract the nid of the question

  if ($notify_p) {
  
    $question_user = user_load($question->uid);

    $params = array(
      '!question_user_name'  => $question_user->name, 
      '!answer_user_name'    => $user->uid == 0 ? 'anonymous' : $user->name, 
      '!question_title'      => $question->title, 
      '!question_url'        => url('node/' . $nid, array('absolute' => TRUE, 'target' => '_blank')),
      '!site'                => variable_get('site_name', 'drupal'),
      );

    drupal_mail('answers', 'new_answer', $question_user->mail, user_preferred_language($question_user), $params);

  };
}

function answers_mail($key, &$message, $params) {
  $langcode = $message['language']->language;
  $message['headers']['Mime-Version'] = '1.0';
  $message['headers']['Content-Type'] = 'text/html; charset=UTF-8; format=flowed';
  
  switch ($key) {
    case 'new_answer':
      $subject_template = variable_get('answers_new_answer_notice_subject', '');
      $message['subject'] = t($subject_template, $params, array('langcode' => $langcode));
      $body_template = variable_get('answers_new_answer_notice_body', '');
      $message['body'][] = t($body_template, $params, array('langcode' => $langcode));
      break;
  }
}

