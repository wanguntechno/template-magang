import {datatableHandleFetchData,datatableHandleDelete} from "/js/helper/datatable.js"
$(function () {
    'use strict';
    //init variable
    const datatable = $('#datatable')

    fetchData()

    function fetchData () {
        let query = new URLSearchParams({
        }).toString()
        datatableHandleFetchData({
            html: datatable,
            url: '/area/grid?'+query,
            column : [
                { title: "Nama", data: 'name'},
                { title: "Kode", data: 'code'}
            ]
        })
    }

    datatableHandleDelete({
        html: datatable,
        url : '/area/'
    })

})
