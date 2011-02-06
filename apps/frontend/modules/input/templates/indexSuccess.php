<?php use_helper('Date'); ?>

<div class="span-6"><h1><?php echo __('Inputs'); ?></h1></div>

<?php if ($sf_user->hasCredential('manager')): ?>
  <div class="span-18 last right">
    <div <?php if ($sf_user->getCurrentInputsUserId() == $sf_guard_user->getId()): ?>class="messages ui-state-highlight ui-corner-all"<?php endif; ?>>
      <?php echo form_tag('@switch_inputs_user'); ?>
        <label for="switch-user-inputs"><?php echo __('Employee'); ?></label> :
        <select id="switch-user-inputs" name="user_id">
          <?php foreach ($users as $user): ?>
            <option value="<?php echo $user->getId(); ?>" <?php echo $sf_guard_user->getId() == $user->getId() ? 'selected="selected"' : '' ?>><?php echo $user->getName(); ?></option>
          <?php endforeach; ?>
        </select>
        <input type="submit" name="switch" value="<?php echo __('ok') ?>" />
      </form>
    </div>
  </div>
<?php endif; ?>

<div class="span-24 append-bottom">
  <div id="input-datepicker" class="span-6"></div>
  <input id="input-url" type="hidden" value="<?php echo url_for('@input'); ?>" />
  <input id="input-date" type="hidden" value="<?php echo $date; ?>" />

  <div class="span-18 last">
    <?php include_partial('flashes'); ?>
    <?php if (isset($input_form)): ?>
      <?php include_partial('form_errors', array('form' => $input_form)); ?>
    <?php endif; ?>
    <h3><?php echo __('Inputs') ?> - <?php echo format_date($date, 'D') ?></h3>
    <?php if (isset($input_form)): ?>
      <div id="input-form" class="ui-widget-content ui-corner-all">
      <h4 class="ui-widget-content no-border no-bg"><?php echo sprintf('[%s] %s', $assignment->getProfile()->getCode(), $assignment->getTask()->getName()); ?></h4>
      <?php echo form_tag($input_form->getObject()->isNew() ? sprintf('@input_new?assignment_id=%d&date=%s', $assignment->getId(), $date) : sprintf('@input_edit?id=%d', $input->getId())); ?>
        <?php echo $input_form->renderHiddenFields(false); ?>
        <table>
          <tr>
            <td class="right">
              <strong><?php echo __('Time allocated') ?></strong>
            </td>
            <td>
              <?php echo format_time($assignment->getTimeAllocated()); ?>
            </td>
            <td class="right">
              <?php echo $input_form['time_spent']->renderLabel(); ?>
              <?php echo $input_form['time_spent']->renderError(); ?>
            </td>
            <td>
              <?php echo $input_form['time_spent']; ?>
            </td>
            <td rowspan="2" class="right">
              <?php echo $input_form['comment']->renderLabel(); ?>
              <?php echo $input_form['comment']->renderError(); ?>
            </td>
            <td rowspan="2">
              <?php echo $input_form['comment']; ?>
            </td>
          </tr>
          <tr>
            <td class="right">
              <?php echo $input_form['is_completed']->renderLabel(); ?>
            </td>
            <td>
              <?php echo $input_form['is_completed']; ?>
            </td>
            <td class="right">
              <?php echo $input_form['time_left']->renderLabel(); ?>
              <?php echo $input_form['time_left']->renderError(); ?>
            </td>
            <td>
              <?php echo $input_form['time_left']; ?>
            </td>
          </tr>
        </table>
        <input type="hidden" name="date" value="<?php echo $date; ?>" />
        <input type="submit" name="save" value="<?php echo __('Save'); ?>" />
        <input type="submit" name="cancel" value="<?php echo __('Cancel'); ?>" />
      </form>
    </div>
    <?php endif; ?>
    <div><?php include_partial('input/input_list', array('inputs' => $inputs, 'date' => $date)); ?></div>
  </div>
</div>

<div class="span-13 clear">
  <h3><?php echo __('Current tasks') ?></h3>
  <?php include_partial('input/task_list', array('assignments' => $current_assignments, 'date' => $date, 'current_assignment_id' => isset($assignment) ? $assignment->getId() : null)); ?>

  <h3><?php echo __('Completed tasks') ?></h3>
  <?php include_partial('input/task_list', array('assignments' => $completed_assignments, 'date' => $date, 'current_assignment_id' => isset($assignment) ? $assignment->getId() : null)); ?>
</div>

<div class="span-11 last">
  <h3><?php echo __('Waiting tasks') ?></h3>
  <?php include_partial('input/task_list', array('assignments' => $waiting_assignments, 'date' => $date, 'with_time_spent' => false, 'current_assignment_id' => isset($assignment) ? $assignment->getId() : null)); ?>
</div>

<script type="text/javascript">
/* <![CDATA[ */
  var $inputs = <?php echo json_encode($all_inputs->getRawValue()); ?>;
/* ]]> */
</script>