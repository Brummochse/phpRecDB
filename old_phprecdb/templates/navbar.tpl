<div id='navBar'>
{section name=index loop=$navBarElements}
    <span id='navBarLinks'>
    <a href='{$navBarElements[index].link}'>{$navBarElements[index].caption}</a>

    {if ! $smarty.section.index.last}
        <span > &gt;</span>
    {/if}
    </span>
{/section}
</div>