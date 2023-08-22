<div class="{if $selected_section !== "logs"}hidden{/if}" id="content_ulsk_order_logs_tab">
    <input class="hidden" id="val_log_id" value="" />
    {include file="addons/ulsk_order_logs/views/orders/components/order_status_logs.tpl"}
<!--content_ulsk_order_logs_tab--></div>

<script>
    //<![CDATA[
        $.ceEvent('on', 'ce.delete_log_callback', function() {
            var data = {
                log_id: $('#val_log_id').val(),
                order_id: {$order_info.order_id}
            };
            var url = fn_url('orders.delete_order_log');

            $.ceAjax('request', url, {
                method: 'post',
                data: data,
                result_ids: 'order_status_logs_result_ids'
            });
        });
    //]]>
</script>
