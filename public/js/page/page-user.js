import {datatableHandleFetchData,datatableHandleDelete} from "/js/helper/datatable.js"
$(function () {
    'use strict';
    //init variable
    const datatable = $('#datatable')
    const group_filter = $('.group-filter')
    const role_filter = $('#role-filter')
    
    group_filter.on('change', function(e) {
        e.preventDefault()
        fetchData()
    })

    fetchData()

    function fetchData () {
        let query = new URLSearchParams({
            role_uuid: role_filter.val(),
        }).toString()
        datatableHandleFetchData({
            html: datatable,
            url: '/user/grid?'+query,
            column : [
                { title: "Username", data: 'username' },
                { title: "Role", data: 'user_role.role.name' },
            ]
        })
    }

    datatableHandleDelete({
        html: datatable,
        url : '/user/'
    })

})
