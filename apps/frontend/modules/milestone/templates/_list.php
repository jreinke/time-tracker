<div class="sf_admin_list">
  <?php if (!$pager->getNbResults()): ?>
    <p><?php echo __('No result', array(), 'sf_admin') ?></p>
  <?php else: ?>
    <div id="ajax-sort-error" class="error_list" style="display: none;"><?php echo __('An error occured while sorting items') ?></div>
    <table cellspacing="0" class="sortable">
      <thead>
        <tr>
          <th id="sf_admin_list_batch_actions"><input id="sf_admin_list_batch_checkbox" type="checkbox" onclick="checkAll();" /></th>
          <?php include_partial('milestone/list_th_tabular', array('sort' => $sort)) ?>
          <th id="sf_admin_list_th_actions"><?php echo __('Actions', array(), 'sf_admin') ?></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th colspan="6">
            <?php if ($pager->haveToPaginate()): ?>
              <?php include_partial('milestone/pagination', array('pager' => $pager)) ?>
            <?php endif; ?>

            <?php echo format_number_choice('[0] no result|[1] 1 result|(1,+Inf] %1% results', array('%1%' => $pager->getNbResults()), $pager->getNbResults(), 'sf_admin') ?>
            <?php if ($pager->haveToPaginate()): ?>
              <?php echo __('(page %%page%%/%%nb_pages%%)', array('%%page%%' => $pager->getPage(), '%%nb_pages%%' => $pager->getLastPage()), 'sf_admin') ?>
            <?php endif; ?>
          </th>
        </tr>
      </tfoot>
      <tbody>
        <?php foreach ($pager->getResults() as $i => $milestone): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
          <tr id="milestone-<?php echo $milestone->getId(); ?>" class="sf_admin_row <?php echo $odd ?>">
            <?php include_partial('milestone/list_td_batch_actions', array('milestone' => $milestone, 'helper' => $helper)) ?>
            <?php include_partial('milestone/list_td_tabular', array('milestone' => $milestone)) ?>
            <?php include_partial('milestone/list_td_actions', array('milestone' => $milestone, 'helper' => $helper)) ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <input id="ajax-sort-url" type="hidden" value="<?php echo url_for('@ajax_milestone_sort') ?>" />
  <?php endif; ?>
</div>
<script type="text/javascript">
/* <![CDATA[ */
function checkAll()
{
  var boxes = document.getElementsByTagName('input'); for(var index = 0; index < boxes.length; index++) { box = boxes[index]; if (box.type == 'checkbox' && box.className == 'sf_admin_batch_checkbox') box.checked = document.getElementById('sf_admin_list_batch_checkbox').checked } return true;
}
/* ]]> */
</script>
