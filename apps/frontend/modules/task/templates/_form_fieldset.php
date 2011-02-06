<fieldset id="sf_fieldset_<?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?>">
  <?php if ('NONE' != $fieldset): ?>
    <h2><?php echo __($fieldset, array(), 'messages') ?></h2>
  <?php endif; ?>

  <?php foreach ($fields as $name => $field): ?>
    <?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?>
    <?php include_partial('task/form_field', array(
      'name'       => $name,
      'attributes' => $field->getConfig('attributes', array()),
      'label'      => $field->getConfig('label'),
      'help'       => $field->getConfig('help'),
      'form'       => $form,
      'field'      => $field,
      'class'      => 'sf_admin_form_row sf_admin_'.strtolower($field->getType()).' sf_admin_form_field_'.$name,
    )) ?>
  <?php endforeach; ?>

  <?php if (! $task->isNew()): ?>
    <div id="task-assignments">
      <?php include_partial('task/assignments', array('task' => $form->getObject())); ?>
    </div>

    <input id="task-assignments-url" type="hidden" value="<?php echo url_for('@task_assignments?id=' . $task->getId()); ?>" />
    <input id="confirm-message" type="hidden" value="<?php echo escape_once(__('Are you sure?')); ?>" />
    <div id="assignment-form-dialog"></div>
    <ul class="sf_admin_actions">
      <li class="sf_admin_action_new"><?php echo link_to(__('New assignment'), '@new_task_assignment?task_id=' . $task->getId(), array('id' => 'new-assignment-link')); ?></li>
    </ul>
  <?php endif; ?>
</fieldset>