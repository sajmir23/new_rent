<script>
    $(document).ready(function () {
        var $vehicle_status_id = $('#vehicle_status_id');
        $vehicle_status_id.select2({
            placeholder: "User",
            allowClear: true,
            ajax: {
                url: "{{ route('company.vehicle_statuses.search') }}",
                dataType: 'json',
                cache: false,
                data: function (params) {
                    return {
                        keyword: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (source) {
                            return {
                                id: source.id,
                                text: source.label
                            };
                        })
                    };
                }
            }
        });
    });

    $(document).ready(function () {
        var $vehicle_category_id = $('#vehicle_category_id');
        $vehicle_category_id.select2({
            placeholder: "User",
            allowClear: true,
            ajax: {
                url: "{{ route('company.vehicle_categories.search') }}",
                dataType: 'json',
                cache: false,
                data: function (params) {
                    return {
                        keyword: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (source) {
                            return {
                                id: source.id,
                                text: source.label
                            };
                        })
                    };
                }
            }
        });
    });

    $(document).ready(function () {
        var $fuel_type_id = $('#fuel_type_id');
        $fuel_type_id.select2({
            placeholder: "User",
            allowClear: true,
            ajax: {
                url: "{{ route('company.fuel_types.search') }}",
                dataType: 'json',
                cache: false,
                data: function (params) {
                    return {
                        keyword: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (source) {
                            return {
                                id: source.id,
                                text: source.label
                            };
                        })
                    };
                }
            }
        });
    });

    $(document).ready(function () {
        var $transmission_type_id = $('#transmission_type_id');
        $transmission_type_id.select2({
            placeholder: "User",
            allowClear: true,
            ajax: {
                url: "{{ route('company.transmission_types.search') }}",
                dataType: 'json',
                cache: false,
                data: function (params) {
                    return {
                        keyword: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (source) {
                            return {
                                id: source.id,
                                text: source.label
                            };
                        })
                    };
                }
            }
        });
    });

    $(document).ready(function () {
        var $vehicle_model_id = $('#vehicle_model_id');
        $vehicle_model_id.select2({
            placeholder: "User",
            allowClear: true,
            ajax: {
                url: "{{ route('company.vehicle_model.search') }}",
                dataType: 'json',
                cache: false,
                data: function (params) {
                    return {
                        keyword: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (source) {
                            return {
                                id: source.id,
                                text: source.vehicles_label
                            };
                        })
                    };
                }
            }
        });
    });
</script>