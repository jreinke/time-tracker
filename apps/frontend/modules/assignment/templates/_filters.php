<?php $cols = 3; ?>
<div class="sf_admin_filter">
  <?php if ($form->hasGlobalErrors()): ?>
    <?php echo $form->renderGlobalErrors() ?>
  <?php endif; ?>
  <form action="<?php echo url_for('assignment_collection', array('action' => 'filter')) ?>" method="post">
    <table cellspacing="0">
      <tfoot>
        <tr>
          <td colspan="<?php echo $cols * 2; ?>">
            <?php echo $form->renderHiddenFields() ?>
            <?php echo link_to(__('Reset', array(), 'sf_admin'), 'assignment_collection', array('action' => 'filter'), array('query_string' => '_reset', 'method' => 'post')) ?>
            <input type="submit" value="<?php echo __('Filter', array(), 'sf_admin') ?>" />
          </td>
        </tr>
      </tfoot>
      <tbody>
        <?php $i = 0; ?>
        <?php foreach ($configuration->getFormFilterFields($form) as $name => $field): ?>
        <?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?>
          <?php if ($i % $cols == 0): ?>
            <tr>
          <?php endif; ?>
          <?php $i++; ?>
          <?php include_partial('assignment/filters_field', array(
            'name'       => $name,
            'attributes' => $field->getConfig('attributes', array()),
            'label'      => $field->getConfig('label'),
            'help'       => $field->getConfig('help'),
            'form'       => $form,
            'field'      => $field,
            'class'      => 'sf_admin_form_row sf_admin_'.strtolower($field->getType()).' sf_admin_filter_field_'.$name,
          )) ?>
          <?php if ($i % $cols == 0): ?>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
        <?php if ($i % $cols > 0): ?>
          <tr>
        <?php endif; ?>
      </tbody>
    </table>
  </form>
</div>
