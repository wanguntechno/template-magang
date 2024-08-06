import {datatableHandleFetchData,datatableHandleDelete} from "/js/helper/datatable.js"
$(function () {
    'use strict';
    //init variable
    const datatable = $('#datatable')
    const group_filter = $('.group-filter')
    const area_filter = $('#area-filter')
    
    group_filter.on('change', function(e) {
        e.preventDefault()
        fetchData()
    })

    fetchData()

    function fetchData () {
        let query = new URLSearchParams({
            area_uuid : area_filter.val()
        }).toString()
        datatableHandleFetchData({
            html: datatable,
            url: '/tenant/grid?'+query,
            column : [
                { title: "Area", data: 'area.name' },
                { title: "Nama", data: 'name' },
                { title: "Email", data: 'email' },
                { title: "Nomor Telepon", data: 'name' },
                { title: "Bank", data: 'bank' },
            ]
        })
    }

    datatableHandleDelete({
        html: datatable,
        url : '/tenant/'
    })

})
