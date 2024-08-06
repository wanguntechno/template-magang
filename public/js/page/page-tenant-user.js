import {datatableHandleFetchData,datatableHandleDelete} from "/js/helper/datatable.js"
$(function () {
    'use strict';
    //init variable
    const datatable = $('#datatable')
    const tenant_uuid = $('#tenant-uuid')

    fetchData()

    function fetchData () {
        let query = new URLSearchParams({
        }).toString()
        datatableHandleFetchData({
            html: datatable,
            url: '/tenant/' + tenant_uuid.val() + '/tenant-user/grid?'+query,
            column : [
                { title: "Tenant", data: 'tenant.name' },
                { title: "Name", data: 'name' },
                { title: "Employee Number", data: 'employee_number' },
                { title: "Phone Number", data: 'phone_number' },
                { title: "Address", data: 'address' },

            ]
        })
    }

    datatableHandleDelete({
        html: datatable,
        url : '/tenant/' + tenant_uuid.val() + '/tenant-user/'
    })

})
