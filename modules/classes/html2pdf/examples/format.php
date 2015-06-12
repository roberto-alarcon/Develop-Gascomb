<style type="text/css">
<!--
table
{
    width:  100%;
    border: solid 1px #5544DD;
}

th
{
    text-align: center;
    border: solid 0px #113300;    
}

td
{
    text-align: left;
    border: solid 0px #55DD44;
}

td.col1
{
    border: solid 0px red;
    text-align: right;
}

-->
</style>
<span style="font-size: 20px; font-weight: bold">Démonstration des retour à la ligne automatique, ainsi que des sauts de page automatique<br></span>
<br>
<br>
<?php
	 $msg = "Le site de html2pdf\r\nhttp://html2pdf.fr/";
?>
 <qrcode value="<?php echo $msg; ?>" ec="L" style="width: 30mm;"></qrcode>
<table>
    <col style="width: 5%" class="col1">
    <col style="width: 40%">
    <col style="width: 5%">    
    <thead>     
    	
        <tr>
            <th rowspan="2">
            <qrcode value="50" ec="L" style="width: 30mm;"></qrcode>
            </th>
            <th colspan="1" style="font-size: 16px;">
                Titre du tableau
            </th>
            <th rowspan="2">No</th>
        </tr>
        <tr>
            <th>Colonne 1</th>            
        </tr>
    </thead>
<?php
    for ($k=0; $k<5; $k++) {
?>
    <tr>
        <td><?php echo $k; ?></td>
        <td>test de texte assez long pour engendrer des retours à la ligne automatique...</td>
        <td>test de texte assez long pour engendrer des retours à la ligne automatique...</td>        
    </tr>
<?php
    }
?>
    <tfoot>
        <tr>
            <th colspan="3" style="font-size: 16px;">
                bas du tableau
            </th>
        </tr>
    </tfoot>
</table>
Cool non ?<br>