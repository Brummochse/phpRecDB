function deleteRecord(url)
{
    if (confirm('Do you really want to delete this record?'))
        location.href = url;
}
function pop(url,pictureId,width,height) {
    width=width+30;
    height=height+30;

    var attr = 'width='+width+',height='+height+',location=no,menubar=no,toolbar=no,status=no,resizable=no,scrollbars=no';
    var newWindow=window.open(url,'max_picture'+pictureId,attr);
    newWindow.focus();
}


function selectAll(artistId) {
    setSelection(true,artistId);
}

function deselectAll(artistId) {
    setSelection(false,artistId);
}

function setSelection(isSelected,artistId) {
    var e;
    if (artistId != null) {
        e = getElementsByClass(artistId,'input');
    } else {
        e = document.getElementsByTagName('input');
    }

    for(var i=0; i<e.length; i++) {
        e[i].checked=isSelected;
    }
}

function getElementsByClass(getClass,tag,node)
{

    // Set optional defaults
    if (tag == null)
        tag = '*';
    if (node == null)
        node = document;

    // Load constants
    const allElements2 = document.getElementsByTagName('*');
    const allElements = node.getElementsByTagName(tag);
    const elements = new Array();
    const pattern = new RegExp("(^|\\s)"+getClass+"(\\s|$)");

    // Loop allElements
    var e = 0;
    for (var i=0; i<allElements.length; i++)
    {
        if (pattern.test(allElements[i].className) ) {
            elements[e] = allElements[i];
            e++;
        }
    }

    // Return elemnts array
    return elements;

}