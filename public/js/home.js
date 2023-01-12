$(document).ready(function () {
    // Link url api
    var urlApi = 'http://127.0.0.1:8000/api/view/home/';
    var urlApiClickProject = 'http://127.0.0.1:8000/api/view/member/';
    var urlApiWorkRoom = 'http://127.0.0.1:8000/api/admin/work-room/';
    var urlApiProject = 'http://127.0.0.1:8000/api/admin/project-edit/';
    var urlApiMember = 'http://127.0.0.1:8000/api/admin/member-edit/';
    var urlApiCompany = 'http://127.0.0.1:8000/api/admin/company/';
    var urlApiSearch = 'http://127.0.0.1:8000/api/view/search/';

    // Edit placeholder input search
    $('input[name=search]').attr('placeholder', 'Search...');

    // Add background color sidebar 
    $('.home').addClass('sidebar-color');

    // Add class scroll content to div main
    // $('.content-all').addClass('scroll-content');

    // Get new date today
    var d = new Date();
    var strDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();

    // Get lists contents
    getContent(urlApi)
    function getContent(url) {
        $.get({
            url: url,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                if (response.status == 200) {
                    // Render first value work room in array
                    $('.box-body-wr, .project-done, .project-doing, .tbody-work-room, .tbody-project, .tbody-member').html('');
                    $.each(response.data, function (key, valWorkRoom) {
                        if (key == 0) {
                            // Render project
                            var i = 1, index = 1;
                            $.each(valWorkRoom.project, function (keyProject, valProject) {
                                if (new Date(valProject.time_completed) <= new Date(strDate)) {
                                    // Render project done
                                    $('.project-done').append(`
                                        <div class="btn-project mb-2 p-1 fs-14 hover border rounded-3"
                                            data-id="${valProject.id}"
                                        >
                                            ${valProject.name}
                                        </div>
                                    `);
                                } else {
                                    // Render project doing
                                    if (keyProject == 0) {
                                        var projectId = valProject.id
                                        // Add color in first item
                                        $('.project-doing').append(`
                                            <div class="btn-project mb-2 p-1 fs-14 hover border rounded-3 btn-primary"
                                                data-id="${valProject.id}"
                                            >
                                                ${valProject.name}
                                            </div>
                                        `);
                                        // Render member in project to table
                                        $.each(valWorkRoom.member, function (key, val) {
                                            if (val.project_id == projectId) {
                                                $('.tbody-member').append(`
                                                    <tr>
                                                        <td>${index++}</td>
                                                        <td data-id="${val.member_id}" class="hover-text-click tb-member">
                                                            ${val.member_name}
                                                        </td>
                                                        <td data-id="${val.company_id}" class="hover-text-click tb-company">
                                                            ${val.company_name}
                                                        </td>
                                                    </tr>
                                                `);
                                            }
                                        });
                                    } else {
                                        $('.project-doing').append(`
                                            <div class="btn-project mb-2 p-1 fs-14 hover border rounded-3"
                                                data-id="${valProject.id}"
                                            >
                                                ${valProject.name}
                                            </div>
                                        `);
                                    }
                                }
                                // Render project details
                                $('.tbody-project').append(`
                                    <tr>
                                        <td>${i++}</td>
                                        <td data-id="${valProject.id}" class="hover-text-click tb-project">
                                            ${valProject.name}
                                        </td>
                                        <td>${valProject.time_start}</td>
                                        <td>${valProject.time_completed}</td>
                                    </tr>
                                `);
                            });
                            // Add color in first item work room
                            $('.box-body-wr').append(`
                                <div class="btn-work-room mb-2 p-1 fs-14 hover border btn-primary rounded-3"
                                    data-id="${valWorkRoom.id}"
                                >
                                    ${valWorkRoom.name}
                                </div>
                            `);
                            // Render work room detail
                            $('.tbody-work-room').append(`
                                <tr>
                                    <td>1</td>
                                    <td data-id="${valWorkRoom.id}" class="hover-text-click tb-wr">
                                        ${valWorkRoom.name}
                                    </td>
                                    <td>${valWorkRoom.location}</td>
                                </tr>
                            `);
                        } else {
                            $('.box-body-wr').append(`
                                <div class="btn-work-room mb-2 p-1 fs-14 hover border rounded-3"
                                    data-id="${valWorkRoom.id}"
                                >
                                    ${valWorkRoom.name}
                                </div>
                            `);
                        }
                    });
                } else {
                    // Alert notification error
                    alertError(response.message);
                }
            }
        });
    }

    // Function show content when click list work rooms
    function showContent(data) {
        // console.log(data);
        $('.project-done, .project-doing, .tbody-work-room, .tbody-project, .tbody-member').html('');
        $.each(data, function (key, valWorkRoom) {
            // Render work room detail
            $('.tbody-work-room').append(`
                <tr>
                    <td>1</td>
                    <td data-id="${valWorkRoom.id}" class="hover-text-click tb-wr">
                        ${valWorkRoom.name}
                    </td>
                    <td>${valWorkRoom.location}</td>
                </tr>
            `);
            if (valWorkRoom.project.length <= 0) {
                $('.card-project, .card-member').addClass('d-none');
                // Notification text not project in work room
                $('.project-done').append('<div class="p-1 border">No projects register in work room</div>');
            } else {
                $('.card-project, .card-member').removeClass('d-none');
                // Render project
                var i = 1, index = 1;
                $.each(valWorkRoom.project, function (keyProject, valProject) {
                    if (new Date(valProject.time_completed) <= new Date(strDate)) {
                        // Render project done
                        $('.project-done').append(`
                            <div class="btn-project mb-2 p-1 fs-14 hover border rounded-3"
                                data-id="${valProject.id}"
                            >
                                ${valProject.name}
                            </div>
                        `);
                    } else {
                        // Render project doing
                        if (keyProject == 0 || keyProject == 1) {
                            var projectId = valProject.id
                            // Add color in first item
                            $('.project-doing').append(`
                                <div class="btn-project mb-2 p-1 fs-14 hover border rounded-3 btn-primary"
                                    data-id="${valProject.id}"
                                >
                                    ${valProject.name}
                                </div>
                            `);
                            // Render member in project to table
                            $.each(valWorkRoom.member, function (key, val) {
                                // console.log(val);
                                if (val.project_id == projectId) {
                                    $('.tbody-member').append(`
                                        <tr>
                                            <td>${index++}</td>
                                            <td data-id="${val.member_id}" class="hover-text-click tb-member">
                                                ${val.member_name}
                                            </td>
                                            <td data-id="${val.company_id}" class="hover-text-click tb-company">
                                                ${val.company_name}
                                            </td>
                                        </tr>
                                    `);
                                }
                            });
                        } else {
                            $('.project-doing').append(`
                                <div class="btn-project mb-2 p-1 fs-14 hover border rounded-3"
                                    data-id="${valProject.id}"
                                >
                                    ${valProject.name}
                                </div>
                            `);
                        }
                    }
                    // Render project details
                    $('.tbody-project').append(`
                        <tr>
                            <td>${i++}</td>
                            <td data-id="${valProject.id}" class="hover-text-click tb-project">
                                ${valProject.name}
                            </td>
                            <td>${valProject.time_start}</td>
                            <td>${valProject.time_completed}</td>
                        </tr>
                    `);
                });
            }
        });
    }

    // Function get content table detail
    function contentTableDetail(data, table) {
        $('.table-show-detail, #modalShowDetail h5').html('');
        $('#modalShowDetail').modal('show');
        switch (table) {
            case 'company':
                $('#modalShowDetail h5').html('Content company details.');
                $('.table-show-detail').append(`
                    <tr>
                        <th>Name:</th>
                        <td>${data.name}</td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td>${data.address}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>${data.email}</td>
                    </tr>
                    <tr>
                        <th>Phone:</th>
                        <td>${data.phone}</td>
                    </tr>
                    <tr>
                        <th>Date incorporation:</th>
                        <td>${data.date_incorporation}</td>
                    </tr>
                    <tr>
                        <th>Date created_at:</th>
                        <td>${data.created_at}</td>
                    </tr>
                    <tr>
                        <th>Date updated_at:</th>
                        <td>${data.updated_at}</td>
                    </tr>
                `);
                break;
            case 'work-room':
                $('#modalShowDetail h5').html('Content work room details.');
                $('.table-show-detail').append(`
                    <tr>
                        <th>Name:</th>
                        <td>${data.name}</td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td>${data.location}</td>
                    </tr>
                    <tr>
                        <th>Date created_at:</th>
                        <td>${data.created_at}</td>
                    </tr>
                    <tr>
                        <th>Date updated_at:</th>
                        <td>${data.updated_at}</td>
                    </tr>
                `);
                break;
            case 'project':
                $('#modalShowDetail h5').html('Content project details.');
                $.each(data, function (key, item) {
                    $('.table-show-detail').append(`
                        <tr>
                            <th>Project name:</th>
                            <td>${item.name}</td>
                        </tr>
                        <tr>
                            <th>Time start:</th>
                            <td>${item.time_start}</td>
                        </tr>
                        <tr>
                            <th>Time completed:</th>
                            <td>${item.time_completed}</td>
                        </tr>
                        <tr>
                            <th>Company name:</th>
                            <td>${item.company.name}</td>
                        </tr>
                        <tr>
                            <th>Company address:</th>
                            <td>${item.company.address}</td>
                        </tr>
                        <tr>
                            <th>Company email:</th>
                            <td>${item.company.email}</td>
                        </tr>
                        <tr>
                            <th>Work room name:</th>
                            <td>${item.work_room.name}</td>
                        </tr>
                        <tr>
                            <th>Work room address:</th>
                            <td>${item.work_room.location}</td>
                        </tr>
                        <tr>
                            <th>Date created:</th>
                            <td>${item.created_at}</td>
                        </tr>
                        <tr>
                            <th>Date updated:</th>
                            <td>${item.updated_at}</td>
                        </tr>
                    `);
                });
                break;
            default:
                $('#modalShowDetail h5').html('Content member details.');
                $.each(data, function (key, item) {
                    $('.table-show-detail').append(`
                        <tr>
                            <th>Member name:</th>
                            <td>${item.name}</td>
                        </tr>
                        <tr>
                            <th>Member email:</th>
                            <td>${item.email}</td>
                        </tr>
                        <tr>
                            <th>Member address:</th>
                            <td>${item.address}</td>
                        </tr>
                        <tr>
                            <th>Phone number:</th>
                            <td>${item.phone_number}</td>
                        </tr>
                        <tr>
                            <th>Work position:</th>
                            <td>${item.work_position}</td>
                        </tr>
                        <tr>
                            <th>Date join company:</th>
                            <td>${item.date_join_company}</td>
                        </tr>
                        <tr>
                            <th>Date left company:</th>
                            <td>${item.date_left_company}</td>
                        </tr>
                        <tr>
                            <th>Company name:</th>
                            <td>${item.company.name}</td>
                        </tr>
                        <tr>
                            <th>Company address:</th>
                            <td>${item.company.address}</td>
                        </tr>
                        <tr>
                            <th>Company email:</th>
                            <td>${item.company.email}</td>
                        </tr>
                        <tr>
                            <th>Date created:</th>
                            <td>${item.created_at}</td>
                        </tr>
                        <tr>
                            <th>Date updated:</th>
                            <td>${item.updated_at}</td>
                        </tr>
                    `);
                });
                break;
        }
    }

    // Function show content detail
    function showContentDetail(url, table) {
        $.get({
            url: url,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                if (response.status == 200) {
                    contentTableDetail(response.data, table);
                } else {
                    // Alert notification add fail
                    alertError(response.message);
                }
            }
        });
    }

    // Function show member content when click list projects
    function showMember(data) {
        var index = 1;
        $('.tbody-member').html('');
        $.each(data, function (key, val) {
            // console.log(val);
            $('.tbody-member').append(`
                <tr>
                    <td>${index++}</td>
                    <td data-id="${val.id}" class="hover-text-click tb-member">
                        ${val.name}
                    </td>
                    <td data-id="${val.company_id}" class="hover-text-click tb-company">
                        ${val.company_name}
                    </td>
                </tr>
            `);
        });
    }

    // Click list content work rooms
    $(document).on('click', '.btn-work-room', function () {
        var id = $(this).attr('data-id');
        $('.btn-work-room').each(function () {
            $('.btn-work-room').removeClass('btn-primary');
        });
        $(this).addClass('btn-primary');
        $.get({
            url: urlApi + id,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                if (response.status == 200) {
                    showContent(response.data)
                } else {
                    // Alert notification error
                    alertError(response.message);
                }
            }, error: function(error) {
                console.log(error);
            }
        });
    });

    // Click list content projects show members and companies
    $(document).on('click', '.btn-project', function () {
        var id = $(this).attr('data-id');
        $('.btn-project').each(function () {
            $('.btn-project').removeClass('btn-primary');
        });
        $(this).addClass('btn-primary');
        $.get({
            url: urlApiClickProject + id,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                if (response.status == 200) {
                    $.each(response.data, function (key, val) { 
                        showMember(val.member_company)
                    });
                } else {
                    // Alert notification error
                    alertError(response.message);
                }
            }
        });
    });

    // Click show content detail worm room
    $(document).on('click', '.tb-wr', function () {
        let id = $(this).attr('data-id');
        let table = 'work-room';
        let url = urlApiWorkRoom + id;
        showContentDetail(url, table);
    });

    // Click show content detail project
    $(document).on('click', '.tb-project', function () {
        let id = $(this).attr('data-id');
        let table = 'project';
        let url = urlApiProject + id;
        showContentDetail(url, table);
    });

    // Click show content detail member
    $(document).on('click', '.tb-member', function () {
        let id = $(this).attr('data-id');
        let table = 'member';
        let url = urlApiMember + id;
        showContentDetail(url, table);
    });

    // Click show content detail company
    $(document).on('click', '.tb-company', function () {
        let id = $(this).attr('data-id');
        let table = 'company';
        let url = urlApiCompany + id;
        showContentDetail(url, table);
    });

    // show list suggestions content
    $('input[name=search]').keyup(function () {
        let nameSearch = $(this).val().replace(/ /g, "");
        // if (nameSearch != '') {
        //     $.get({
        //         url: urlApiSearch + nameSearch,
        //         dataType: 'json',
        //         success: function (response) {
        //             // console.log(response.data);
        //             if (response.status == 200) {
        //                 $('.result-search').removeClass('d-none');
        //                 $('.result-search').html('');
        //                 $.each(response.data, function (key, item) {
        //                     // console.log(item);
        //                     $('.result-search').append(`
        //                         <li class="hover-text-click" data-id="${item.id}" >${item.company.name}</li>
        //                     `);
        //                 });
        //             } else {
        //                 $('.result-search').addClass('d-none');
        //             }
        //         }
        //     });
        // } else {
        //     $('.result-search').addClass('d-none');
        // }
    }); 

    // Click show suggestions content detail
    $(document).on('click', '.result-search li', function () {
        let id = $(this).attr('data-id');
        let content = $(this).text();
        $('input[name=search]').val(content);
        $('.result-search').addClass('d-none');
        let url = urlApiEdit + id;
        // showContentDetail(url, table = 'cabinet');
    });

    // Click button search content
    $(document).on('click', '.btn-search', function (e) {
        e.preventDefault();
        let contentSearch = $('input[name=search]').val();
        // $.get({
        //     url: urlApiSearch + contentSearch,
        //     dataType: "json",
        //     success: function (response) {
        //         console.log(response);
        //         if (response.status == 200) {
        //             // contentTableDetail(response.data, table = 'cabinet');
        //         } else {
        //             // Alert notification add fail
        //             alertError(response.message);
        //         }
        //     }
        // });
    });

});