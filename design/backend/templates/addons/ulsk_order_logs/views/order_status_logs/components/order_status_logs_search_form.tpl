<div class="sidebar-row">
<h6>{__("admin_search_title")}</h6>

{if $page_part}
    {assign var="_page_part" value="#`$page_part`"}
{/if}

<form action="{""|fn_url}{$_page_part}" name="order_status_logs_search_form" method="get" class="cm-disable-empty-all {$form_meta}">
<input type="hidden" name="type" value="{$search_type|default:"simple"}" />
{if $smarty.request.redirect_url}
    <input type="hidden" name="redirect_url" value="{$smarty.request.redirect_url}" />
{/if}
{if $selected_section != ""}
    <input type="hidden" id="selected_section" name="selected_section" value="{$selected_section}" />
{/if}

{if $put_request_vars}
    {array_to_fields data=$smarty.request skip=["callback"]}
{/if}

{$extra nofilter}

{capture name="simple_search"}
    <div class="sidebar-field">
        <label>{__("id")}</label>
        <input type="text" name="id" size="20" value="{$search.id}" />
    </div>

    <div class="sidebar-field">
        <label>{__("order_id")}</label>
        <input type="text" name="order_id" size="20" value="{$search.order_id}" />
    </div>

    <div class="sidebar-field">
        <label>{__("ulsk_order_logs.status_old")}</label>
        <select name="status_old" id="status_old">
            <option value="">--</option>
            {foreach from=$order_statuses key=key item=status}
                <option value="{$key}" {if $search.status_old == $key}selected="selected"{/if}>{$status.description}</option>
            {/foreach}
        </select>
    </div>

    <div class="sidebar-field">
        <label>{__("ulsk_order_logs.status_new")}</label>
        <select name="status_new" id="status_new">
            <option value="">--</option>
            {foreach from=$order_statuses key=key item=status}
                <option value="{$key}" {if $search.status_new == $key}selected="selected"{/if}>{$status.description}</option>
            {/foreach}
        </select>
    </div>

{/capture}

{capture name="advanced_search"}
<div class="row-fluid">
    <div class="group span6 form-horizontal">

        <div class="control-group">
            <label for="status" class="control-label">{__("order_status")}</label>
            <div class="controls">
                <select name="status" id="status">
                    <option value="">--</option>
                    {foreach from=$order_statuses key=key item=status}
                        <option value="{$key}" {if $search.order_status == $key}selected="selected"{/if}>{$status.description}</option>
                    {/foreach}
                </select>
            </div>
        </div>

        <div class="control-group">
            <label for="firstname" class="control-label">{__("first_name")}</label>
            <div class="controls">
                <input type="text" name="firstname" size="20" value="{$search.firstname}" />
            </div>
        </div>

        <div class="control-group">
            <label for="lastname" class="control-label">{__("last_name")}</label>
            <div class="controls">
                <input type="text" name="lastname" size="20" value="{$search.lastname}" />
            </div>
        </div>

        <div class="control-group">
            <label for="order_firstname" class="control-label">{__("ulsk_order_logs.first_name")}</label>
            <div class="controls">
                <input type="text" name="order_firstname" size="20" value="{$search.order_firstname}" />
            </div>
        </div>

        <div class="control-group">
            <label for="order_lastname" class="control-label">{__("ulsk_order_logs.last_name")}</label>
            <div class="controls">
                <input type="text" name="order_lastname" size="20" value="{$search.order_lastname}" />
            </div>
        </div>

    </div>
</div>

<div class="group form-horizontal">
    <div class="control-group">
        <label class="control-label">{__("period")}</label>
        <div class="controls">
            {include file="common/period_selector.tpl" period=$search.period form_name="order_status_logs_search_form"}
        </div>
    </div>
</div>
{/capture}

{include file="common/advanced_search.tpl" simple_search=$smarty.capture.simple_search advanced_search=$smarty.capture.advanced_search dispatch=$dispatch view_type="products"}

</form>

</div><hr>
