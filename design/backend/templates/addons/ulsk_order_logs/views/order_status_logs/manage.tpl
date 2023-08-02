{capture name="mainbox"}
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
                        check_statuses=$order_status_logs
                        meta="table__check-items"
                        }

                        <input type="checkbox"
                               class="bulkedit-toggler hide"
                               data-ca-bulkedit-disable="[data-ca-bulkedit-default-object=true]"
                               data-ca-bulkedit-enable="[data-ca-bulkedit-expanded-object=true]"
                        />
                    </th>
                    <th width="15%">
                        {include file="common/table_col_head.tpl" type="id"}
                    <th width="17%">
                        {include file="common/table_col_head.tpl" type="date"}
                    </th>
                    <th width="*">
                        {include file="common/table_col_head.tpl" type="user" text=__("firstname")}
                    </th>
                    <th width="10%" class="right">
                        {include file="common/table_col_head.tpl" type="status_old"}
                    </th>
                    <th width="10%" class="right">
                        {include file="common/table_col_head.tpl" type="status_new"}
                    </th>
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
                        <input type="checkbox" name="log_ids[]" value="{$log.log_id}" class="cm-item cm-item-status-{$log.status_new|lower} hide" />
                    </td>
                    <td width="15%" class="table__first-column" data-th="{__("id")}">
                        {$log.log_id}
                    </td>
                    <td width="17%" data-th="{__("date")}">{$log.timestamp|date_format:"`$settings.Appearance.date_format`, `$settings.Appearance.time_format`"}</td>
                    <td width="*" class="table__first-column" data-th="{__("user")}">
                        {if $log.user_firstname ne ""}
                        <a href="">{$log.user_firstname}{if $log.user_lastname ne ""} {$log.user_lastname}{/if}</a>
                        {else}
                            {$log.order_firstname}
                        {/if}
                    </td>
                    <td width="15%" class="table__first-column" data-th="{__("status_old")}">
                        {$log.status_old}
                    </td>
                    <td width="15%" class="table__first-column" data-th="{__("status_new")}">
                        {$log.status_new}
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
{/capture}

{capture name="buttons"}
test button
{/capture}

{capture name="sidebar"}
Test
{/capture}

{include file="common/mainbox.tpl" title=__("order_status_logs") content=$smarty.capture.mainbox buttons=$smarty.capture.buttons sidebar=$smarty.capture.sidebar content_id="order_status_log"}