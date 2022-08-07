import baseUrl from "../base.js";
import basePath from "../domain.js";

$("#tot").bind('change', function () {
                               
    tampil();
                        
});
$( "#sbmTot" ).click(function(e) {
    e.preventDefault();
   tampil();


});
tampil();
function tampil(){
  var tot = $('#tot').val();
   var html = "";
                                      
    for (let i = 0; i < tot; i++) {
        html += " <div class='col-md-4 form-group mb-3'><input type='text' name='submodul[]'  class='form-control' placeholder='Submodul Name' ></div><div class='col-md-4 form-group mb-3'><input type='text' name='slug[]'  class='form-control' placeholder='Submodul Slug' ></div><div class='col-md-4 form-group'><select class='form-control' name='publish[]' ><option value='y'>Publish</option><option value='n' selected>Unpublish</option></select></div>";;
     }
    $('#tampilInput').html(html);
                                          
}