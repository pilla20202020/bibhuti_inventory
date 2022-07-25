$('#temp_country_id').on('change', function(e) {
    e.preventDefault();
    var country_id = $(this).val();
    var body = "";
    $.ajax({
        type: 'POST',
        url: provincesByCountryId,
        data: {
            _token: $("meta[name='csrf-token']").attr('content'),
            country_id: country_id,
        },
        success: function(response) {
            // if(typeof(response) != "object"){
            //     response = JSON.parse(response);
            // }
            $('#temp_province_id').html('');
            $('#temp_district_id').html('');
            body = '<option value="" selected disabled>Select Province</option>';
            if (response.provinces) {
                $.each(response.provinces, function(key, province) {
                    body += "<option value='" + province['id'] + "'>" + province['province_name'] + "</option>";
                });
                $('#temp_province_id').html(body);
            }
        }
    })
})


$('#temp_province_id').on('change', function(e) {
    e.preventDefault();
    var province_id = $(this).val();
    var body = "";
    $.ajax({
        type: 'POST',
        url: districtByProvinceId,
        data: {
            _token: $("meta[name='csrf-token']").attr('content'),
            province_id: province_id,
        },
        success: function(response) {
            $('#temp_district_id').html('');
            body = '<option value="" selected disabled>Select District</option>';
            if (response.districts) {
                $.each(response.districts, function(key, district) {
                    body += "<option value='" + district['id'] + "'>" + district['district_name'] + "</option>";
                });
                $('#temp_district_id').html(body);
            }
        }
    })
})