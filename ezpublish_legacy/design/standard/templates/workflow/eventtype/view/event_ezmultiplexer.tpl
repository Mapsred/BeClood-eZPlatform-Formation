{* DO NOT EDIT THIS FILE! Use an override template instead. *}

<div class="element">
{let selectedSections=$event.selected_sections}
{"Sections"|i18n("design/standard/workflow/eventtype/view")}:

{section show=$selectedSections|contains(-1)}
{"Any"|i18n("design/standard/workflow/eventtype/view")}
{section-else}

{let comma=false()}
{section var=section loop=$event.workflow_type.sections}
{section show=$selectedSections|contains($section.value)}
{if $comma}, {/if}
{$section.Name|wash}
{set comma=true()}
{/section}
{/section}
{/let}

{/section}

{/let}
</div>


<div class="element">
{let selectedClasses=$event.selected_classes}
{"Classes to run workflow"|i18n("design/standard/workflow/eventtype/view")}:

{section show=$selectedClasses|contains(-1)}
{"Any"|i18n("design/standard/workflow/eventtype/view")}
{section-else}

{let comma=false()}
{section var=class loop=$event.workflow_type.contentclass_list}
{if $selectedClasses|contains($class.value)}
{if $comma}, {/if}
{$class.Name|wash}
{set comma=true()}
{/if}
{/section}
{/let}

{/section}

{/let}
</div>


<div class="element">
{let selectedGroups=$event.selected_usergroups}
{"Users without workflow IDs"|i18n("design/standard/workflow/eventtype/view")}:

{let comma=false()}
{section var=user loop=$event.workflow_type.usergroups}
{if $selectedGroups|contains($user.value)}
{if $comma}, {/if}
{$user.Name|wash}
{set comma=true()}
{/if}
{/section}
{/let}

{/let}
</div>


<div class="element">
{let selectedWorkflow=$event.selected_workflow}
{"Workflow to run"|i18n("design/standard/workflow/eventtype/view")}:

{section var=workflow loop=$event.workflow_type.workflow_list}
{if $selectedWorkflow|eq($workflow.value)}
{$workflow.Name|wash}
{/if}
{/section}

{/let}
</div>


<div class="element">
{"Language"|i18n("design/standard/workflow/eventtype/view")}:

{if eq( count( $event.language_list ), 0 )}
    {"Any"|i18n( "design/standard/workflow/eventtype/view" )}
{else}
    {section var=language loop=$event.language_list}
        {delimiter}, {/delimiter}
    {$language|wash}
    {/section}
{/if}
</div>


<div class="element">
{'Affected versions'|i18n( 'design/admin/workflow/eventtype/edit' )}:
{if or( lt($event.version_option, 1), gt($event.version_option, 2) )}&nbsp;{'All versions'|i18n( 'design/admin/workflow/eventtype/edit' )}
{elseif eq( $event.version_option, 1)}&nbsp;{'Publishing new object'|i18n( 'design/admin/workflow/eventtype/edit' )}
{elseif eq( $event.version_option, 2)}&nbsp;{'Updating existing object'|i18n( 'design/admin/workflow/eventtype/edit' )}
{else}&nbsp;-&nbsp;{/if}
</div>
