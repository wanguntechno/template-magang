import {datatableHandleFetchData,datatableHandleEvent} from "/js/helper/datatable.js"
$(function () {
    'use strict';
    //init variable
    const role_uuid = $('#role-uuid')
    const datatable = $('#datatable')

    datatableHandleFetchData({
        html : datatable,
        url : "/role/"+role_uuid.val()+"/permission/grid",
        column : [
        { width: "30%", title: "Permission", data: 'permission' },
        { width: "70%",  title: "Access", data: 'access' },
        ]
    },false,false)

    datatableHandleEvent({
        html: datatable,
        onEvent: 'change',
        classEvent: 'tbody .form-check-input',
        triggerEvent : function (e) {
            e.preventDefault()
             //updateRolePermssion
             $ajaxJsonUpdate({
                url : '/role/' + role_uuid.val() + '/permission/update-role',
                data : {
                    'permission_uuid' : this.id,
                },
            })
        }
    })
})