<br>
  <div style="text-align:center;">
       <div style="text-align:left;width:300px;margin-left:auto;margin-right:auto;border:1px #000000 solid;padding:20px;">
       <b>Compress uploaded Screenshots (for saving memory space)</b>
        <br />
        <br />
        <form action='' method='POST' >
        {html_radios name="compr" options=$compr selected=$compr_id separator="<br />"}

        <br />
        <input type='hidden' value='1' name='submitted' />
        <input type='submit' value='save' />
      
     </form>
      </div>
</div>