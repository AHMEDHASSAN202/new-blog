var url = window.location.toString();

$(function() {

    //toggle bars navbar and content page and sidebar
    toggleBars();
    //active links
    activeLinks();

    /*Users Page==================================================*/
    //load users by ajax
    if (url.indexOf('users') >= 0) {
        loadData(1, function(result) {
            return tableBodyForUsersPage(result);
        });
    }

    //load nav card
    $('.loadByAjax a').on('click', function(e) {
        e.preventDefault();
        if (!$(this).parent('li').hasClass('active')) {
            loadData(1, function(result) {
                return tableBodyForUsersPage(result);
            }, $(this).attr('href'));
        }
    });

    //change count page
    changePagePagination();

    //users search
    search(function(result) {
        if (result.page == 'users') {
            return tableBodyForUsersPage(result.items);
        }else if (result.page == 'posts') {
            return preparePostsTable(result.items);
        }
    });

    //pagination users, posts, users group, and moreeeee
    pagination(function (result) {
        return tableBodyForUsersPage(result);
    });
    /*#END# Users Page=============================================*/

    /* Load Modal ================================================*/
    modalLoad();
    /*#END# Modal ================================================*/

    /*Save Data by Ajax ============================================*/
    saveData();
    /*#END# Save Data by Ajax ============================================*/

    /*Delete Data =====================================================*/
    loadModalDeleteData();
    afterDeleteData();
    /*#END# delete data ================================================*/

    /*View Data users, posts, categories =============================*/
    viewData()
    /*#END# view data =============================================*/

    /*Categories Page ==============================================*/
    saveCategoryData();
    setDataInCategoriesTable(null);
    deleteCat();
    setParentCategoriesInAddForm();
    /*#END# categories page ============================================*/

    /*Roles =====================================*/
    prepareCheckbox();
    rolePutGroupsInTable(null);
    deleteRoles();
    saveRole()
    editRole()
    parentCheckbox()
    /*#END# Roles =====================================*/

    /*POST ==================================================*/
    loadPostsComponent()
    addTag();
    deleteTage();
    addPost()
    paginationPosts();
    deletePosts();
    component();
    /*#END# POST ==================================================*/

    /*Messages ===============================================*/
    deleteMessages();
    viewMessages();
    replyMessage();
    /*#END# Messages ===============================================*/

    /*Settings ===================================================*/
    save_settings();
    /*#END# Settings ===================================================*/
})



function toggleBars()
{
    var bars = $('#bars');
    var wrapper = $('#wrapper');

    //expands boxes
    var boxes = $('#boxes > div');

    var extendCards = $('.extend-section > div');

    //expends nav
    var  nav = $('#nav');

    bars.on('click' , function() {
        bars.toggleClass('open');
        wrapper.toggleClass('open-sidebar');
        boxes.toggleClass('col-lg-6 col-lg-3');
        nav.toggleClass('col-md-9 col-md-11');
        extendCards.toggleClass('col-md-12');
    });
}

function search(successfulFunction)
{
    var search = $('.search-input');
    var url = search.data('url');
    var targetElement = search.data('target');

    search.on('keyup', function() {
        $.ajax({
            url: url,
            data: {value: search.val()},
            type: 'get',
            dataType: 'json',
            beforeSend: function() {
                if (search.val().length >= 1) {
                    $(targetElement).html('<div class="text-center px-4">Loading...</div>');
                }else {
                    return;
                }
            },
            success: function(result) {
                tbody = successfulFunction(result);
                $(targetElement).html(tbody);
            }
        });
    });
}

function pagination (successfulFunction)
{
    var theElement = $('#pagination');
    var targetElement = theElement.data('target');
    theElement.on('change', function() {
        var url = theElement.data('url') + $('.andPag .active').data('pagination');
        $.ajax({
            url: url,
            dataType: 'json',
            data: {pagination: theElement.val()},
            type: 'get',
            beforeSend: function() {
                $(targetElement).html('<div class="text-center px-4">Loading...</div>');
            },
            success: function(result) {
                $(targetElement).html(successfulFunction(result.items));
            }
        });
    })
}

function loadData(page, func, url)
{
    var url =  (url !== undefined) ? url : $('.ajaxTable').data('url');
    var target = $('.ajaxTable').data('target');
    $.ajax({
        url: url,
        type: 'get',
        dataType: 'json',
        data: {page: page},
        beforeSend: function() {
            $(target).html('<div class="text-center px-4">Loading...</div>');
        },
        success: function(result) {
            tbody = func(result.items);
            $(target).html(tbody);
            var ul = '';
            for(var i=0; result.count_pages > i; i++) {
                ul += '<li id="'+ (i+1) +'" class="page-item count_page"><a class="page-link">' + (i+1) +'</a></li>';
            }
            $('.pagination').html(ul);
            $('li#'+page).addClass('active');
        }
    });
}

function changePagePagination()
{
    $(document).on('click', '.count_page > a',function(e) {
        if (!$(this).parent('li').hasClass('active')) {
            e.preventDefault();
            loadData($(this).parent().attr('id'), function(result) {
                return tableBodyForUsersPage(result);
            });
        }
    });
}

function activeLinks()
{
    $('ul.activelinks li').on('click', function() {
        $(this).addClass('active').siblings().removeClass('active');
    })
}

function tableBodyForUsersPage(result)
{
    tbody = '';
    for (var i=0; i < result.length; i++) {
        viewBTN = (result[i].view == false) ? 'hidden' : null;
        editBTN = (result[i].edit == false) ? 'hidden' : null;
        deleteBTN = (result[i].delete == false) ? 'hidden' : null;
        tr = '<tr>';
        tr += '<th>'+ (i+1) +'</th>';
        tr += '<td>'+result[i].name+'<div class="badge badge-success mx-1">'+ result[i].permission +'</div></td>';
        tr += '<td>'+result[i].email+'</td>';
        tr += '<td>'+result[i].createdDate+'</td>';
        tr += '<td>';
        tr +=   '<button '+ viewBTN +' data-url="'+ result[i].view +'" type="button" class="btn btn-outline-info view-btn btn-action" title="view">\n' +
                '<i class="fas fa-eye"></i>\n' +
                '</button>\n';
        tr +=   '<button '+ editBTN +' data-url="'+ result[i].edit +'" type="button" class="btn btn-outline-primary btn-action modal-load" title="Edit">\n' +
                '<i class="fas fa-user-edit"></i>\n' +
                '</button>\n';
        tr +=   '<button '+ deleteBTN +' data-url="'+ result[i].delete +'" type="button" class="btn btn-outline-danger btn-action delete-btn" data-target="#delete-modal" title="Delete">\n' +
                '<i class="fas fa-trash-alt"></i>\n' +
                '</button>';
        tr += '</td>';
        tr += '</tr>';
        tbody += tr;
    }
    return tbody;
}

function modalLoad() {
    modal = '.modal-load';
    $(document).on('click', modal, function() {
        $.ajax({
            type: 'get',
            dataType: 'html',
            url: $(this).data('url'),
            success: function(modal) {
                if ($('#modalSection').length) {
                    $('body').find('#modalSection').remove();
                }
                $('body').append(modal);
                $('body').find('#modalSection').modal('show');
            }
        });
    });
}

function saveData()
{
    form = '.saveByAjax';
    $(document).on('submit',form, function(e) {
        e.preventDefault();
        var data = new FormData($(this)[0]);
        $.ajax({
            url: $(this).attr('action'),
            data: data,
            type: $(this).attr('method'),
            dataType: 'json',
            beforeSend: function() {
                $('.saveByAjax .msg').html('<span class="d-block text-center text-muted p-4">Loading...</span>');
            },
            success: function(result) {
                if (result.errors) {
                    $('.saveByAjax .msg').html('<div class="alert-danger col py-3">'+ result.errors +'</div>');
                }else if (result.success) {
                    loadData(1, function(result) {
                        return tableBodyForUsersPage(result);
                    }, $('body').find('.activelinks .loadByAjax.active a').attr('href'));
                    $('.saveByAjax .msg').html('<div class="alert-success col py-3">'+ result.success +'</div>');
                    $('body').find('#modalSection').modal('hide');
                }
            },
            cache: false,
            processData: false,
            contentType: false
        });
    });
}

function loadModalDeleteData()
{
    btn = '.delete-btn';
    $(document).on('click', btn, function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        $('.delete-ok').attr('data-url', url);
        $($(this).data('target')).modal('show');
    })
}

function afterDeleteData()
{
    $('.delete-ok').on('click', function () {
        $.ajax({
            url: $(this).attr('data-url'),
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result.redirect) {
                    window.location.href = result.redirect;
                    return;
                }
                if (result.errors) {
                    $('#delete-modal').find('.msg').html('<div class="alert-danger col py-3">'+ result.errors +'</div>');
                }else if (result.success) {
                    loadData(1, function(result) {
                        return tableBodyForUsersPage(result);
                    }, $('body').find('.activelinks .loadByAjax.active a').attr('href'));
                    $('#delete-modal').modal('hide');
                }
            }
        })
    });
}

function viewData()
{
    $(document).on('click', '.view-btn', function() {
        $.ajax({
            url: $(this).data('url'),
            type: 'get',
            dataType: 'html',
            beforeSend: function(){
                if ($('#view-data').length) {
                    $('#view-data').remove();
                }
            },
            success: function(result){
                if (result) {
                    $('body').append(result)
                    $('#view-data').modal('show');
                }
            }
        });
    });
}

function saveCategoryData()
{
    $(document).on('submit','.cat-form', function(e) {
        url = $(this).attr('action');
        method = $(this).attr('method');
        data = new FormData($(this)[0]);
        e.preventDefault();
        $.ajax({
            url: url,
            type: method,
            dataType: 'json',
            data: data,
            beforeSend: function() {
                $(this).find('.msg').html('<div class="text-muted text-center mb-4">Loading...</div>');
            },
            success: function(result) {
                if (result.errors) {
                    edit = result.edit ? '.edit' : '';
                    $('.cat-form'+edit).find('.msg').html('<div class="alert-danger p-3 mb-3">'+ result.errors +'</div>');
                } else if (result.success) {
                    setDataInCategoriesTable(result.categories);
                    setParentCategoriesInAddForm(result.categories);
                    if (result.edit) {
                        //edit category
                        $('.cat-form.edit').find('.msg').html('<div class="alert-success p-3 mb-3">'+ result.success +'</div>');
                        $('#modalSection').modal('hide');
                    }else {
                        //add new category
                        $('.cat-form').find('.msg').html('<div class="alert-success p-3 mb-3">'+ result.success +'</div>');
                        $('.cat-form')[0].reset();
                        setTimeout(function () {
                            $('.cat-form').find('.msg > div').remove();
                        }, 8000)
                    }
                }
            },
            processData: false,
            cache: false,
            contentType: false
        });
        return false;
    });
}

function setDataInCategoriesTable(categroriesPar)
{
    if (typeof  categories === 'undefined')     {
        return;
    }
    categories = categroriesPar !== null ? categroriesPar : categories;
    if (typeof tableCat === 'function'){
        $('.table-cat').find('tbody').html(tableCat(categories));
    }
}

function deleteCat()
{
    $(document).on('click', '.deleteCat', function() {
        if (confirm('Want to delete ?')) {
            $.ajax({
                url: $(this).attr('data-url'),
                type: 'get',
                dataType: 'json',
                success: function(result){
                    if (result.errors) {
                        $('.msg-t').html('<div class="alert alert-danger">'+ result.errors +'</div>');
                    }else if (result.success) {
                        $('.msg-t').html('<div class="alert alert-success">'+ result.success +'</div>');
                        setDataInCategoriesTable(result.categories);
                        setParentCategoriesInAddForm(result.categories);
                    }
                }
            });
            setTimeout(function() {$('.msg-t').remove()}, 5000);
        }
    })
}

function setParentCategoriesInAddForm(ParentCategories)
{
    if (typeof  categories === 'undefined')     {
        return;
    }
    categories = ParentCategories != null ? ParentCategories : categories;
    if (typeof parentCategoriesOptions === 'function') {
        $('.p-c').html(parentCategoriesOptions(categories));
    }
}

function prepareCheckbox()
{
    $('.roles-div ul li:first-child input[type=checkbox]').on('click', function() {
        if ($(this).is(':checked')) {
            $(this).parents('li').siblings().find('input').attr('disabled', false);
        }else {
            $(this).parents('li').siblings().find('input').attr('disabled', true).prop('checked', false);
        }
    })
}

function rolePutGroupsInTable(overrideGroups)
{
    if (typeof  groups === 'undefined') {
        return;
    }
    groups = overrideGroups != null ? overrideGroups : groups;
    $('.body-roles').html(putGroupsInTable(groups));
}

function deleteRoles()
{
    $(document).on('click', '.delete-role', function() {
        if (!confirm('Want to delete ?')) {
            return false;
        }
        $.ajax({
            url: $(this).data('url'),
            dataType: 'json',
            type: 'get',
            success: function(results) {
                processResults(results, '.table-role .msg-t', function(results) {
                    rolePutGroupsInTable(results);
                });
            }
        });
    });
}

function processResults(results, msg_element, func)
{
    if (results.errors) {
        $(msg_element).html('<div class="alert alert-danger">'+ results.errors +'</div>');
    }else if (results.success) {
        $(msg_element).html('<div class="alert alert-success">'+ results.success +'</div>');
        func(results.groups);
        setTimeout(function () {
            $(msg_element+ ' div').remove();
        }, 5000);
    }
}

function saveRole()
{
    $('.role-save').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            dataType: 'json',
            type: $(this).attr('method'),
            data: $(this).serialize(),
            success: function(result) {
                processResults(result, '.role-save .msg', function(groups) {
                    rolePutGroupsInTable(groups);
                    resetForm();
                });
            }
        })
    });
}

function editRole()
{
    form = $('.role-save');
    $(document).on('click', '.edit-role', function() {
        resetForm();
        form.attr('action', $(this).data('url'));
        $.ajax({
            url: $(this).data('target'),
            type: 'get',
            dataType: 'json',
            success: function(result) {
                if (result) {
                    form.find('#group-name').val(result.name);
                    for (var i=0; i < result.permissions.length; i++) {
                        form.find('#'+result.permissions[i].name).val(result.permissions[i].url).attr('disabled', false).prop('checked', true);
                    }
                    form.find('li:first-child input[type=checkbox]').each(function() {
                        if ($(this).is(':checked')) {
                            $(this).parents('li').siblings().find('input').attr('disabled', false);
                        }else {
                            $(this).parents('li').siblings().find('input').attr('disabled', true).prop('checked', false);
                        }
                        $(this).parents('div').siblings('input').prop('checked', $(this).prop('checked'));
                    });

                }
            }
        })
    });
}

function resetForm(form)
{
    form = form != null ? form : $('.role-save');
    form.attr('action', form.data('target'));
    form.find('input[type=text]').val('');
    form.find('li:not(:first-child) input[type=checkbox]').each(function() {
        $(this).prop('checked', false).attr('disabled', true);
    });
    form.find('li:first-child input[type=checkbox]').each(function() {
        $(this).prop('checked', false);
    });
}

function parentCheckbox()
{
    $('.parent-checkbox').click(function () {
        $(this).parents('div').siblings('input').prop('checked', $(this).prop('checked'));
    })
    $('.parent-checkbox').each(function () {
        $(this).parents('div').siblings('input').prop('checked', $(this).prop('checked'));
    })
}

function loadPostsComponent()
{

    $('.load-component').on('click', function (e) {
        e.preventDefault();
        $(this).toggleClass('open');
        if ($(this).hasClass('open')) {
            url = $(this).attr('href');
        }else {
            url = $(this).data('target');
        }
        loadComponents(url);
    });
}

function loadComponents(url)
{
    var loadingDIV = $('.gif-loading');
    var cardBody = $('#body-card');
    $.ajax({
        url: url,
        dataType: 'html',
        type: 'get',
        beforeSend: function () {
            loadingDIV.css('display', 'block');
        },
        success: function(result) {
            loadingDIV.css('display', 'none');
            cardBody.html(result);
        }
    })
}

function addTag()
{

    $('#tags').keypress(function (e) {
        if (e.keyCode == '13') {
            e.preventDefault();
        }
    })
    $(document).on('click', '#addTag', function () {
        val = $('#tags').val();
        i = Date.now() + Math.random();
        tagsDiv = $('#tags-div');
        tagElement = '<div id="t-'+ i +'" class="tag d-inline-block">\n' +
            '                    <label for="t-'+ i +'" class="">'+ val +'</label>\n' +
            '                    <input name="tags[]" value="'+ val +'" hidden id="t-'+ i +'" type="text">\n' +
            '                    <span class="close-span badge badge-danger"><i class="fas fa-times"></i></span>\n' +
            '                </div>';
        tagsDiv.append(tagElement);
        $('#tags').val('');
    })
}

function deleteTage()
{
    $(document).on('click', '.close-span', function() {
        $(this).parents('.tag').remove();
    })
}

function addPost()
{
    $(document).on('submit', '.save-post', function(e) {
        e.preventDefault();
        data = new FormData($(this)[0]);
        loading = $('.gif-loading');
        $.ajax({
            url: $(this).attr('action'),
            data: data,
            type: $(this).attr('method'),
            dataType: 'json',
            beforeSend: function() {
                loading.css('display', 'block');
            },
            success: function(result) {
                loading.css('display', 'none')
                if (result.errors) {
                    $('.save-post').find('.msg').html(result.errors);
                }else if(result.success) {
                    $('.save-post').find('.msg').html('<div class="alert alert-success">'+ result.success +'</div>');
                    $('.save-post')[0].reset();
                    $('#editor').val('');
                    $('.save-post').find('input[name="tags[]"]').parent('div').remove();
                    setInterval(function() {
                        $('.save-post').find('.msg div').remove();
                    }, 3000);
                    if (result.redirect) {
                        return loadComponents(result.redirect);
                    }
                }
            },
            cache: false,
            processData: false,
            contentType: false
        })
    });
}

function paginationPosts()
{
    pagination = $('#pagination-post');
    $(document).on('change', '#pagination-post', function() {
        //alert('??');
        urlRequest = pagination.data('target');
        value = $(this).val();
        $.ajax({
            url: urlRequest,
            data: {pagination: value},
            dataType: 'json',
            type: 'get',
            beforeSend: function() {
                $('#body-card .gif-loading').css('display', 'block');
            },
            success: function(result) {
                if (result) {
                   $('#body-card .gif-loading').css('display', 'none');
                   preparePostsTable(result.items);
                   createPaginationButtons(result.count_pages,result.current_page)
                }
            }
        })
    })
}

function ajaxPagination(e) {
    if (!($(e.target).parents('li').hasClass('active'))) {
        $.ajax({
            url: paginationUrl,
            type: 'get',
            dataType: 'json',
            data: {page: $(e.target).attr('data-target')},
            beforeSend: function() {
                $('#body-card .gif-loading').css('display', 'block');
            },
            success: function(result) {
                $('#body-card .gif-loading').css('display', 'none');
                preparePostsTable(result.items);
                createPaginationButtons(result.count_pages, result.current_page);
            }
        })
    }
}

function deletePosts()
{
    $(document).on('click', '.deletePost', function() {
        if (!confirm('Want to delete ?')) {
            return false;
        }
        $.ajax({
            url: $(this).attr('data-url'),
            type: 'get',
            dataType: 'json',
            success: function(result) {
                if (result.errors) {
                    $('.body-card .msg').html('<div class="alert alert-danger">'+ result.errors +'</div>')
                }else if (result.success) {
                    $('.body-card .msg').html('<div class="alert alert-success">'+ result.success +'</div>')
                    preparePostsTable(result.items);
                    createPaginationButtons(result.count_pages, result.current_page);
                }
                setTimeout(function() {
                    $('.body-card .msg div').remove();
                }, 5000)
            }
        })
    })
}

function component() {
    $(document).on('click', '.component', function() {
        url = $(this).data('url');
        loadComponents(url);
    })
}

function deleteMessages()
{
    $(document).on('click', '.deleteMsg', function() {
        if (!confirm('Want to delete ?')) {
            return false;
        }
        $.ajax({
            url: $(this).attr('data-url'),
            type: 'get',
            dataType: 'json',
            success: function(result) {
                if (result.errors) {
                    $('.body-card .msg').html('<div class="alert alert-danger">'+ result.errors +'</div>')
                }else if (result.success) {
                    $('.body-card .msg').html('<div class="alert alert-success">'+ result.success +'</div>')
                    messagesTable(result.messages)
                }
                setTimeout(function() {
                    $('.body-card .msg div').remove();
                }, 5000)
            }
        })
    })
}

function viewMessages() {
    $(document).on('click', '.viewMsg', function() {
        $.ajax({
            url: $(this).data('url'),
            type: 'get',
            dataType: 'html',
            beforeSend: function() {
                $('.gif-loading').css('display', 'block');
                if ($($('body').find('#viewMsg')).length) {
                    $($('body').find('#viewMsg')).remove();
                }
            },
            success: function(result) {
                $('.gif-loading').css('display', 'none');
                $('body').append(result);
                $($('body').find('#viewMsg')).modal('show');
            }
        })
    })
}

function replyMessage()
{
    $(document).on('submit', '#reply_msg', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            dataType: 'json',
            data: $(this).serialize(),
            success: function(result) {
                if (result.errors) {
                    $('#reply_msg').find('.msg').html(result.errors);
                }else if (result.success) {
                    $('#reply_msg').find('.msg').html('<div class="alert alert-success">'+ result.success +'</div>');
                    messagesTable(result.messages);
                    setTimeout(function() {
                        $($('body').find('#viewMsg')).modal('hide');
                    }, 3000)
                }
            }
        })
    })
}

function save_settings()
{
    $(document).on('submit', '#settings', function(e) {
        e.preventDefault();
        data = new FormData($(this)[0]);
        $.ajax({
            url: $(this).attr('action'),
            data: data,
            type: $(this).attr('method'),
            dataType: 'json',
            beforeSend: function () {
                $('#body-card .gif-loading').css('display', 'block');
            },
            success: function(result) {
                $('#body-card .gif-loading').css('display', 'none');
                if (result.errors) {
                    $('.msg').html(result.errors);
                }else if (result.success) {
                    $('.msg').html('<div class="alert alert-success">'+ result.success +'</div>');
                    $(this).find('#siteName').val(result.settings.site_name);
                    $(this).find('#emailSite').val(result.settings.site_email);
                    $(this).find('#copyRight').val(result.settings.site_copyright);
                    $(this).find('#s_c_m').val(result.settings.site_close_msg);
                    if (result.settings.site_status == 1) {
                        $(this).find('#customControlInline').prop('checked', true);
                    }else {
                        $(this).find('#customControlInline').prop('checked', false);
                    }
                    setTimeout(function() {
                        $('.msg > div').remove();
                    }, 3000);
                }
            },
            cache: false,
            contentType: false,
            processData: false
        })
    });
}