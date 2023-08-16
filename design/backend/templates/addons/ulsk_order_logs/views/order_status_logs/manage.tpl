{capture name="mainbox"}

<form action="{""|fn_url}" method="post" name="manage_order_status_logs_form" class="form-horizontal form-edit cm-ajax" id="manage_order_status_logs_form">
{* <input type="hidden" name="result_ids" value="pagination_contents,tools_content_id_order_status_log_buttons" /> *} {* tools_content_id_order_status_log_buttons - is needed if you have the 'Save' button at the top of page *}
<input type="hidden" name="result_ids" value="pagination_contents" />

{include file="common/pagination.tpl" save_current_page=true save_current_url=true div_id=$smarty.request.content_id}

{*
{$return_url = $config.current_url|escape:"url"}
{$c_url = $config.current_url|fn_query_remove:"sort_by":"sort_order"}    
*}

{if $order_status_logs}
    {capture name="order_status_logs_table"}
        <div class="table-responsive-wrapper longtap-selection">
            <table width="100%" class="table table-middle table-responsive table--overflow-hidden">
            <thead
                    data-ca-bulkedit-default-object="true"
                    data-ca-bulkedit-component="defaultObject"
            >
                <tr>
                    <th class="left table__check-items-column">
                        {include file="common/check_items.tpl"
                        is_check_all_shown=true
                        check_statuses=$selectable_statuses
                        meta="table__check-items"
                        }

                        <input type="checkbox"
                               class="bulkedit-toggler hide"
                               data-ca-bulkedit-disable="[data-ca-bulkedit-default-object=true]"
                               data-ca-bulkedit-enable="[data-ca-bulkedit-expanded-object=true]"
                        />
                    </th>
                    <th width="5%">
                        {include file="common/table_col_head.tpl" type="id"}
                    </th>
                    <th width="10%">
                        {include file="common/table_col_head.tpl" type="order"}
                    </th>
                    <th width="10%">
                        {include file="common/table_col_head.tpl" type="status"}
                    </th>
                    <th width="17%">
                        {include file="common/table_col_head.tpl" type="date"}
                    </th>
                    <th width="*" class="center">
                        {include file="common/table_col_head.tpl" type="user" text=__("first_name")}
                    </th>
                    <th width="15%" class="right">
                        {include file="common/table_col_head.tpl" type="status_old" text=__("ulsk_order_logs.status_old")}
                    </th>
                    <th width="15%" class="right">
                        {include file="common/table_col_head.tpl" type="status_new" text=__("ulsk_order_logs.status_new")}
                    </th>
                    <th width="5%"></th>
                </tr>
            </thead>
            {foreach $order_status_logs as $log}
                <tbody class="cm-row-item cm-row-status-{$log.status_new|lower} cm-longtap-target"
                       data-ca-longtap-action="setCheckBox"
                       data-ca-longtap-target="input.cm-item"
                       data-ca-id="{$log.log_id}"
                >
                <tr>
                    <td class="left mobile-hide table__check-items-cell">
                        <input type="checkbox" name="logs_post_data[{$log.log_id}][order_id]" value="{$log.order_id}" class="cm-item cm-item-status-{$log.status|lower} hide" />
                    </td>
                    <td width="5%" class="table__first-column" data-th="{__("id")}">
                        {$log.log_id}
                    </td>
                    <td width="10%" data-th="{__("order")}">
                        <a href="{fn_url("orders.details&order_id={$log.order_id}")}">{$log.order_id}</a>
                    </td>
                    <td width="15%" data-th="{__("status")}">
                        {$order_statuses[$log.status].description|default:$log.status}
                    </td>
                    <td width="17%" data-th="{__("date")}">{$log.timestamp|date_format:"`$settings.Appearance.date_format`, `$settings.Appearance.time_format`"}</td>
                    <td width="*" class="table__first-column" data-th="{__("user")}">
                        {if $log.user_firstname ne ""}
                        <a href="{fn_url("profiles.update&user_id={$log.user_id}")}">{$log.user_firstname}{if $log.user_lastname ne ""} {$log.user_lastname}{/if}</a>
                        {else}
                            {$log.order_firstname} {$log.order_lastname}
                        {/if}
                    </td>
                    <td width="15%" class="table__first-column" data-th="{__("status_old")}">
                        {$order_statuses[$log.status_old].description|default:$log.status_old}
                    </td>
                    <td width="15%" class="table__first-column" data-th="{__("status_new")}">
                        {$order_statuses[$log.status_new].description|default:$log.status_new}
                    </td>
                    <td class="nowrap">
                        <div class="hidden-tools">
                            {capture name="tools_list"}
                                <li>{btn type="list" text=__("delete") href="order_status_logs.delete?log_id=`$log.log_id`" class="cm-confirm" method="POST"}</li>
                            {/capture}
                            {dropdown content=$smarty.capture.tools_list}
                        </div>
                    </td>
                </tr>
                </tbody>
            {/foreach}
            </table>
        </div>
    {/capture}

    {include file="common/context_menu_wrapper.tpl"
    form="manage_order_status_logs_form"
    object="order_status_logs"
    items=$smarty.capture.order_status_logs_table
    }
{else}
    <p class="no-items">{__("no_data")}</p>
{/if}

{capture name="buttons"}
    {if $order_status_logs}
        {* include file="buttons/save.tpl" but_name="dispatch[order_status_logs.m_update]" but_role="submit-link" but_target_form="manage_order_status_logs_form" *}
    {/if}
{/capture}

<div class="clearfix">
    {include file="common/pagination.tpl" div_id=$smarty.request.content_id}
</div>

</form>
{/capture}

{capture name="sidebar"}
    {include file="common/saved_search.tpl" dispatch="order_status_logs.manage" view_type="order_status_logs_object"}
    {include file="addons/ulsk_order_logs/views/order_status_logs/components/order_status_logs_search_form.tpl" dispatch="order_status_logs.manage"}
{/capture}

{include file="common/mainbox.tpl" title=__("ulsk_order_logs.order_status_logs") content=$smarty.capture.mainbox buttons=$smarty.capture.buttons sidebar=$smarty.capture.sidebar content_id="content_id_order_status_log"}
