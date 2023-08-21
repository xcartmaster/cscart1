<div id="order_status_logs_result_ids">
    {if $order_status_logs}
        <table width="100%" class="table table-middle table--relative">
            <thead>
            <tr>
                <th width="5%" class="center">{__("id")}</th>
                <th width="5%" class="center">{__("ulsk_order_logs.log_id")}</th>
                <th width="30%">{__("user")}</th>
                <th width="15%" class="left">{__("ulsk_order_logs.status_old")}</th>
                <th width="15%" class="left">{__("ulsk_order_logs.status_new")}</th>
                <th width="15%" class="center">{__("date")}</th>
                <th width="15%" class="center">{__("delete")}</th>
            </tr>
            </thead>
            {foreach from=$order_status_logs item=log}
                {math equation="x+1" x=$log_id|default:0 assign="log_id"}
                <tr>
                    <td class="center">#{$log_id}</td>
                    <td class="center">#{$log.log_id}</td>
                    <td>
                        {if $log.user_firstname ne ""}
                            <a href="{fn_url("profiles.update&user_id={$log.user_id}")}">{$log.user_firstname}{if $log.user_lastname ne ""} {$log.user_lastname}{/if}</a>
                        {else}
                            {$log.order_firstname} {$log.order_lastname}
                        {/if}
                    </td>
                    <td class="left">{$order_statuses[$log.status_old].description|default:$log.status_old}</td>
                    <td class="left">{$order_statuses[$log.status_new].description|default:$log.status_new}</td>
                    <td class="center">
                        {$log.timestamp|date_format:"`$settings.Appearance.date_format`"},&nbsp;{$log.timestamp|date_format:"`$settings.Appearance.time_format`"}
                    </td>
                    <td class="center">
                        <a class="cm-ajax ty-btn" href="{"orders.delete_order_log"|fn_url}" onclick="$('#val_log_id').val('{$log.log_id}');" data-ca-event="ce.delete_log_callback">{__("delete")}</a>
                    </td>
                </tr>
            {/foreach}
        </table>
    {else}
        <p class="no-items">{__("no_data")}</p>
    {/if}
    <!--order_status_logs_result_ids--></div>