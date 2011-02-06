<div class="sf_admin_filter">
  <?php if ($form->hasGlobalErrors()): ?>
    <?php echo $form->renderGlobalErrors() ?>
  <?php endif; ?>

  <form action="<?php echo url_for('@report_filter') ?>" method="post">
    <table cellspacing="0">
      <tfoot>
        <tr>
          <td colspan="2">
            <?php echo $form->renderHiddenFields() ?>
            <?php echo link_to(__('Reset', array(), 'sf_admin'), '@report_reset_filter') ?>
            <input type="submit" value="<?php echo __('Filter', array(), 'sf_admin') ?>" />
          </td>
        </tr>
      </tfoot>
      <tbody>
        <tr>
          <td class="right">
            <?php echo $form['milestone_id']->renderLabel('Milestone'); ?>
          </td>
          <td>
            <?php echo $form['milestone_id']->renderError(); ?>
            <?php echo $form['milestone_id']->render(); ?>
          </td>
          <td class="right">
            <?php echo $form['module_id']->renderLabel('Module'); ?>
          </td>
          <td>
            <?php echo $form['module_id']->renderError(); ?>
            <?php echo $form['module_id']->render(); ?>
          </td>
          <td class="right">
            <?php echo $form['profile_id']->renderLabel('Profile'); ?>
          </td>
          <td>
            <?php echo $form['profile_id']->renderError(); ?>
            <?php echo $form['profile_id']->render(); ?>
          </td>
        </tr>
        <tr>
          <td class="compact right">
            <?php echo $form['user_id']->renderLabel('User'); ?>
          </td>
          <td>
            <?php echo $form['user_id']->renderError(); ?>
            <?php echo $form['user_id']->render(); ?>
          </td>
          <td class="compact right">
            <?php echo $form['input_date']->renderLabel('Input date'); ?>
          </td>
          <td>
            <?php echo $form['input_date']->renderError(); ?>
            <?php echo $form['input_date']->render(); ?>
          </td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
