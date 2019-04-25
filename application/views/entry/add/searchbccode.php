
<div class="row-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Business Concern Code</label>
                <input class="form-control" type="text" name="lookup_bccode" id="lookup_bccode">
            </div>
        </div>
    </div>
    <div class="row pull-right">
        <button class="btn btn-sm btn-success searchbccode" id="searchbccode" name="searchbccode">Search</button>
    </div>
    <legend></legend>
</div>

<div class="row-fluid" style="overflow:auto;height:500px">
    <table cellpadding="0" cellspacing="0" style="white-space:nowrap;width:400px" class="table">
        <thead>
            <tr>
                <th width="5%">Code</th>
                <th width="15%">Business Concern</th>
            </tr>
        </thead>
        <tbody class="search_bcdetails">
        </tbody>
    </table>
    <div class="clear"></div>
<script>

var errorcssobj = {'background': '#EED3D7','border' : '1px solid #ff5b57'};
var errorcssobj2 = {'background': '#cee','border' : '1px solid #00acac'};

$(".searchbccode").click(function() {
    var $lookup_bccode = $("#lookup_bccode").val();
    $.ajax({
        url: "<?php echo site_url('entry/searchingforbusinesscode')?>",
        type: "post",
        data: {lookup_bccode: $lookup_bccode},
        success: function(response) {
            var $response = $.parseJSON(response);
            {
                $(".search_bcdetails").html($response['search_bcdetails']);
            }
        }
    });
});


</script>
