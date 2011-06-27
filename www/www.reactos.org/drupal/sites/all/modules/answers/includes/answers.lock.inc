<?php
// $Id$

/**
 * @file
 * Question locking functions for the 'Answers' module
 * 
 * @author Chip Cleary
 * 
 */

/* 
 * The Answers module allow questions to be "locked", meaning that users are no longer permitted to 
 * provide new answers to them.
 *
 * The logic about *which* questions to lock may be set by developers or by other modules. For example,
 * the Best Answer module locks questions after a Best Answer is selected while the (under construction) 
 * Expire Questions module locks questions after they have passed an expiration date.
 *
 * To support locking, this file provides a hook and some utility functions.
 *
 * The hook:
 *   - hook_answers_lock_question_p: Modules that want to set or release locks should define this hook. It returns TRUE
 *     if a question should be locked.
 *
 * The utility functions:
 *   - answers_lock_question: Lock a question
 *   - answers_unlock_question: Unlock a question
 *   - answers_reset_question_locks: Cycle through all questions and reset their locks. (This can be required when, e.g.,
 *     a global policy is changed. For example, an administrator may change the policy in the Best Answers module to lock
 *     questions after a Best Answer is selected. When this happens, the module calls this function to update the locks.).
 *
 */

function answers_reset_question_locks () {
  $modules = module_implements('answers_lock_question_p');
  $result = db_query("SELECT * from {node} WHERE type = 'question';");
  foreach($result as $question) {
    $question = node_load($question->nid);
    if (answers_lock_question_p($question, $modules)) {
      answers_lock_question($question);
    }
    else {
      answers_unlock_question($question);
    }
  }
}

function answers_lock_question_p($question, $modules=NULL) {
  if (!$modules) {
    $modules = module_implements('answers_lock_question_p');
  }
  
  foreach($modules as $module) {
    if (module_invoke($module, 'answers_lock_question_p', $question)) {
      return TRUE;
    }
  }

  return FALSE;
}

function answers_lock_question($question) {
  $question->field_question_locked_p['und'][0]['value'] = 1;
  node_save($question);
}

function answers_unlock_question($question) {
  $question->field_question_locked_p['und'][0]['value'] = 0;
  node_save($question);
}
