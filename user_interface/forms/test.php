<script src="./dhtmlxLibrary/dhtmlxToolbar/codebase/dhtmlxcommon.js"></script>
<script src="./dhtmlxLibrary/dhtmlxToolbar/codebase/dhtmlxtoolbar.js"></script>
<link rel="stylesheet" type="text/css" href="./dhtmlxLibrary/dhtmlxToolbar/codebase/skins/dhtmlxtoolbar_dhx_blue.css">
	
<script type="text/javascript" src="./dhtmlxLibrary/dhtmlxToolbar/codebase/dhtmlxcommon.js"></script>
<script type="text/javascript" src="./dhtmlxLibrary/dhtmlxToolbar/codebase/dhtmlxtoolbar.js"></script>
<link rel="stylesheet" type="text/css" href="./dhtmlxLibrary/dhtmlxToolbar/codebase/skins/dhtmlxtoolbar_dhx_skyblue.css"></link>
 
<div id="toolbarObj"></div>
<div style="margin-top: 20px;">
<table cellspacing="0" cellpadding="2" border="0">
    <tr>
        <td style="padding-right: 5px;">Position</td>
        <td><input id="txt1" type="text" value="1" style="width: 30px;"></td>
    </tr>
    <tr>
        <td style="padding-right: 5px;">Text</td>
        <td><input id="txt2" type="text" value="New Text"></td>
    </tr>
    <tr>
        <td style="padding-right: 5px;">Add?</td>
        <td><input type="button" value="Add" onclick="add();"></td>
    </tr>
</table>
<table cellspacing="0" cellpadding="2" border="0" style="margin-top: 10px;">
    <tr>
        <td style="padding-right: 5px;"><select id="sel"></select></td>
        <td><input type="button" value="Remove" onclick="remove();"></td>
    </tr>
</table>
</div>
<script>
var sel = document.getElementById("sel");
var toolbar = new dhtmlXToolbarObject("toolbarObj");
toolbar.setIconsPath("./dhtmlxLibrary/dhtmlxToolbar/codebase/imgs/");
toolbar.setSkin('dhx_skyblue');
toolbar.loadXML("./dhtmlxLibrary/dhtmlxToolbar/common/dhxtoolbar_text.xml?etc=" + new Date().getTime(), updateList);
function add() {
    var id = String(new Date().getTime());
    var pos = Number(document.getElementById("txt1").value);
    var text = String(document.getElementById("txt2").value);
    toolbar.addText(id, pos, text);
    updateList();
}
function remove() {
    if (sel.options.length == 0) {
        return;
    }
    toolbar.removeItem(sel.options[sel.selectedIndex].value);
    updateList();
}
function updateList() {
    sel.options.length = 0;
    toolbar.forEachItem(function(itemId) {
        if (toolbar.getType(itemId) == "text") {
            sel.options.add(new Option(toolbar.getItemText(itemId), itemId));
        }
    });
}
</script>