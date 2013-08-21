{if isset($concertId)}
<p>Concert added Successfully with ConcertID: ({$concertId})!</p>
{/if}

{if isset($recordingId)}
    <p>Recording Added Successfully with RecordingID: ({$recordingId})!</p>
{/if}
<p>

{if $c_videoOrAudio=='video'}
	videoId: ({$videoId})
{/if}

{if $c_videoOrAudio=='audio'}
	audioId: ({$audioId})
{/if}


</p>
{if isset($editRecordLink)}
    <p><a href='{$editRecordLink}'>edit Recording</a></p>
{/if}