
<div class="row-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Action Code</label>
                <input class="form-control" type="text" name="lookup_apcode" id="lookup_apcode">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
            <?php foreach ($data as $row) : ?>
            <?php if ($row['apis_approved'] == 0) : ?>
            <input class="form-control" type="hidden" name="existcodes" id="existcodes" value="<?php echo $row['code'] ?>">
            <?php endif; ?>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="row pull-right">
        <button class="btn btn-sm btn-success searchcode" id="searchcode" name="searchcode">Search</button>
        <!--<button class="btn btn-sm btn-white" id="importcode" name="importcode">Import</button>-->
    </div>
    <legend></legend>
</div>

<div class="row-fluid" style="overflow:auto;height:500px">
    <table cellpadding="0" cellspacing="0" style="white-space:nowrap;width:400px" class="table">
        <thead>
            <tr>
                <th width="5%">Code</th>
                <th width="15%">Action Plan</th>
            </tr>
        </thead>
        <tbody class="search_detailscode">
        </tbody>
    </table>
    <div class="clear"></div>
<script>

var errorcssobj = {'background': '#EED3D7','border' : '1px solid #ff5b57'};
var errorcssobj2 = {'background': '#cee','border' : '1px solid #00acac'};

$("#searchcode").click(function() {
    var $lookup_apcode = $("#lookup_apcode").val();
    var $bc_code = $("#bc_code").val();
    $.ajax({
        url: "<?php echo site_url('entry/searchingforcode')?>",
        type: "post",
        data: {lookup_apcode: $lookup_apcode, bc_code: $bc_code},
        success: function(response) {
            var $response = $.parseJSON(response);
            $(".search_detailscode").html($response['search_detailscode']);
        }
    });
});


</script>
