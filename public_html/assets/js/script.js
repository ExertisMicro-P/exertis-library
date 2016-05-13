$(function () {

    var filemanager = $('.filemanager'),
        breadcrumbs = $('.breadcrumbs'),
        zipDiv      = $('#zipinfo'),
        fileList    = filemanager.find('.data');

    // Start by fetching the file data from scan.php with an AJAX request

    $.get('scan.php', function (data) {

        var response        = [data],
            currentPath     = '',
            breadcrumbsUrls = [];

        var folders = [],
            files   = [];

        var zipCount = 0 ;
        var zipItems = [] ;

        // This event listener monitors changes on the URL. We use it to
        // capture back/forward navigation in the browser.

        $(window).on('hashchange', function () {

            goto(window.location.hash);

            // We are triggering the event. This will execute
            // this function on page load, so that we show the correct folder:

        }).trigger('hashchange');


        // Hiding and showing the search box

        filemanager.find('.search').click(function () {

            var search = $(this);

            search.find('span').hide();
            search.find('input[type=search]').show().focus();

        });


        // Listening for keyboard input on the search field.
        // We are using the "input" event which detects cut and paste
        // in addition to keyboard input.

        filemanager.find('input').on('input', function (e) {

            folders = [];
            files   = [];

            var value = this.value.trim();

            if (value.length) {

                filemanager.addClass('searching');

                // Update the hash on every key stroke
                window.location.hash = 'search=' + value.trim();

            }

            else {

                filemanager.removeClass('searching');
                window.location.hash = encodeURIComponent(currentPath);

            }

        }).on('keyup', function (e) {

            // Clicking 'ESC' button triggers focusout and cancels the search

            var search = $(this);

            if (e.keyCode == 27) {

                search.trigger('focusout');

            }

        }).focusout(function (e) {

            // Cancel the search

            var search = $(this);

            if (!search.val().trim().length) {

                window.location.hash = encodeURIComponent(currentPath);
                search.hide();
                search.parent().find('span').show();

            }

        });


        /**
         * SELECT FILE/FOLDER FOR ZIPPING
         * ==============================
         * Listens for clicks on the 'checkbox', whether on a folder or a
         * file, and uses it to keep a count of the selected items
         */
        fileList.on('click', 'input.selectf', function (event) {
            event.stopPropagation() ;

            var filePath = $(this).parents('li').find('a.folders, a.files').attr('href');
            var fItem = findDataItem(response, filePath) ;
            if (fItem.checked != $(this).prop('checked') ) {
                fItem.checked = $(this).prop('checked');
                if (fItem.checked) {
                    zipCount++ ;

                } else {
                    zipCount-- ;
                }
                if (zipCount) {
                    zipDiv.find('span').text('You have selected ' + zipCount + ' items for zipping').end().fadeIn();
                } else {
                    zipDiv.fadeOut();
                }
            }

        });

        // Clicking on folders

        fileList.on('click', 'li.folders', function (e) {
            e.preventDefault();

            var nextDir = $(this).find('a.folders').attr('href');

            if (filemanager.hasClass('searching')) {

                // Building the breadcrumbs

                breadcrumbsUrls = generateBreadcrumbs(nextDir);

                filemanager.removeClass('searching');
                filemanager.find('input[type=search]').val('').hide();
                filemanager.find('span').show();
            }
            else {
                breadcrumbsUrls.push(nextDir);
            }

            window.location.hash = encodeURIComponent(nextDir);
            currentPath          = nextDir;
        });


        // Clicking on breadcrumbs

        breadcrumbs.on('click', 'a', function (e) {
            e.preventDefault();

            var index   = breadcrumbs.find('a').index($(this)),
                nextDir = breadcrumbsUrls[index];

            breadcrumbsUrls.length = Number(index);

            window.location.hash = encodeURIComponent(nextDir);

        });

        /**
         * DOWNLOAD CLICK
         * ==============
         * Responds to a click on the download link by gathering the complete
         * list of selected items. These are sent ot the server to process, and
         * the return includes the name of hte zip file, if created.
         *
         * The zip is then autoamtically downloaded by creating a dummy link
         * tag and triggering it's click event
         */
        zipDiv.on('click', 'a', function (event) {
            zipItems = [] ;
            gatherZipitems(response) ;
            if (zipItems.length) {
                zipDiv.find('a').css('visibility', 'hidden') ;
                $.post('zipup.php', {files: zipItems})
                    .done(function (data) {
                        if (data.ok) {
                            ($('<a>').attr('href', data.filename))[0].click() ;
                            zipDiv.find('a').css('visibility', 'visible') ;
                        }
                    }) ;
            }
            return false ;

        })

        zipDiv.on('submit', function (event) {
            zipItems = [] ;
            gatherZipitems(response) ;
            if (zipItems.length) {
                zipDiv.find('input[type=hidden]').val(JSON.stringify(zipItems)) ;

            } else {
                return false;
            }

        })
        
        $('html').on('click', function(){
       $.modal.close(); 
    });


    $(document).on('mouseover', 'a.files', function(){

       var file = $(this).attr('title');
       var fileExt = file.split('.')[1];
       var previewExts = ['jpg', 'png', 'gif', 'pdf', 'doc', 'docx'];

       if($.inArray(fileExt, previewExts) !== -1){
           $(this).append('<span class="previewText">Click To Preview</span>');
       }

    });

    $(document).on('mouseout', 'a.files', function(){

        $('.previewText').html('');

    });
    
    $(document).on('click', 'a.files', function(e) {
        e.stopPropagation();
        
        image = $(this).attr('href');
        fileExt = image.split('.')[1];
        previewExts = ['jpg', 'png', 'gif', 'pdf', 'doc', 'docx'];
        
        if($.inArray(fileExt, previewExts) !== -1){
        e.preventDefault();
        
            if(fileExt === 'jpg' || fileExt === 'png' || fileExt === 'gif') {
                $.modal('<div><img src="'+image+'" class="previewimage"></div>');
            }
            
            if(fileExt === 'pdf') {
                $.modal('<div><iframe src="'+image+'" style="width:100%; height:500px; overflow: hidden; border:0px" scrolling="no"></div>');
                $('.simplemodal-container').addClass('pdfpreview');
            }
            
            if(fileExt == 'doc' || fileExt === 'docx') {
                $.modal('<div><iframe src="https://view.officeapps.live.com/op/embed.aspx?src=http://library.exertis.co.uk/'+image+'" style="width:100%; height:500px; overflow: hidden; border:0px" scrolling="no"></div>');
                $('.simplemodal-container').addClass('pdfpreview');
            }
            
        }
        
    });
        


        /**
         * GATHER ZIP ITEMS
         * ================
         * A recursively called function and for each that has a set 'checked'
         * flag and builds a list of items to zip
         *
         * @param data
         * @returns {boolean}
         */
        function gatherZipitems(data) {
            var result = false ;

            data.forEach(function (d) {
                if (d.checked) {
                    zipItems.push({type: d.type, name: d.path}) ;
                }
                if (d.type === 'folder') {
                    gatherZipitems(d.items) ;
                }
            });
            return result ;
        }



        // Navigates to the given hash (path)

        function goto(hash) {

            hash = decodeURIComponent(hash).slice(1).split('=');

            if (hash.length) {
                var rendered = '';

                // if hash has search in it

                if (hash[0] === 'search') {

                    filemanager.addClass('searching');
                    rendered = searchData(response, hash[1].toLowerCase());

                    if (rendered.length) {
                        currentPath = hash[0];
                        render(rendered);
                    }
                    else {
                        render(rendered);
                    }

                }

                // if hash is some path

                else if (hash[0].trim().length) {

                    rendered = searchByPath(hash[0]);

                    if (rendered.length) {

                        currentPath     = hash[0];
                        breadcrumbsUrls = generateBreadcrumbs(hash[0]);
                        render(rendered);

                    }
                    else {
                        currentPath     = hash[0];
                        breadcrumbsUrls = generateBreadcrumbs(hash[0]);
                        render(rendered);
                    }

                }

                // if there is no hash

                else {
                    currentPath = data.path;
                    breadcrumbsUrls.push(data.path);
                    render(searchByPath(data.path));
                }
            }
        }

        // Splits a file path and turns it into clickable breadcrumbs

        function generateBreadcrumbs(nextDir) {
            var path = nextDir.split('/').slice(0);
            for (var i = 1; i < path.length; i++) {
                path[i] = path[i - 1] + '/' + path[i];
            }
            return path;
        }


        // Locates a file by path

        function searchByPath(dir) {
            var path = dir.split('/'),
                demo = response,
                flag = 0;

            for (var i = 0; i < path.length; i++) {
                for (var j = 0; j < demo.length; j++) {
                    if (demo[j].name === path[i]) {
                        flag = 1;
                        demo = demo[j].items;
                        break;
                    }
                }
            }

            demo = flag ? demo : [];
            return demo;
        }

        /**
         * FIND DATA ITEM
         * ==============
         * This scans the tree looking for the passed item. It is used to search
         * for the item clicked on in order to toggle it's state between to zip
         * and not.
         *
         * @param data
         * @param searchTerms
         * @returns {boolean}
         */
        function findDataItem(data, searchTerms) {
            var result = false ;

            searchTerms = searchTerms.toLowerCase() ;
            data.forEach(function (d) {
                if (d.type === 'folder') {

                    if (d.path.toLowerCase() == searchTerms) {
                        result = d ;
                        return true ;
                    }
                    var finfo = findDataItem(d.items, searchTerms);
                    if (finfo !== false) {
                        result = finfo ;
                        return true ;
                    }
                }
                else if (d.type === 'file') {
                    if (d.path.toLowerCase() === searchTerms) {
                        result = d ;
                        return true ;
                    }
                }
            });
            return result ;
        }


        // Recursively search through the file tree

        function searchData(data, searchTerms) {

            data.forEach(function (d) {
                if (d.type === 'folder') {

                    searchData(d.items, searchTerms);

                    if (d.name.toLowerCase().match(searchTerms)) {
                        folders.push(d);
                    }
                }
                else if (d.type === 'file') {
                    if (d.name.toLowerCase().match(searchTerms)) {
                        files.push(d);
                    }
                }
            });
            return {folders: folders, files: files};
        }


        // Render the HTML for the file manager

        function render(data) {

            var scannedFolders = [],
                scannedFiles   = [];

            if (Array.isArray(data)) {

                data.forEach(function (d) {

                    if (d.type === 'folder') {
                        scannedFolders.push(d);
                    }
                    else if (d.type === 'file') {
                        scannedFiles.push(d);
                    }

                });

            }
            else if (typeof data === 'object') {

                scannedFolders = data.folders;
                scannedFiles   = data.files;

            }


            // Empty the old result and make the new one

            fileList.empty().hide();

            if (!scannedFolders.length && !scannedFiles.length) {
                filemanager.find('.nothingfound').show();
            }
            else {
                filemanager.find('.nothingfound').hide();
            }

            if (scannedFolders.length) {

                scannedFolders.forEach(function (f) {

                    var itemsLength = f.items.length,
                        name        = escapeHTML(f.name),
                        icon        = '<span class="icon folder"></span>';

                    if (itemsLength) {
                        icon = '<span class="icon folder full"></span>';
                    }

                    if (itemsLength == 1) {
                        itemsLength += ' item';
                    }
                    else if (itemsLength > 1) {
                        itemsLength += ' items';
                    }
                    else {
                        itemsLength = 'Empty';
                    }

                    // -------------------------------------------------------
                    // added a fancy checkbox to the top of the item
                    // -------------------------------------------------------
                    var folder = $('<li class="folders">' +
                        '<a href="' + f.path + '" title="' + f.path + '" class="folders">' +
                        icon +
                        '<span class="name">' +
                        name +
                        '</span> ' +
                        '<span class="details">' +
                        itemsLength +
                        '</span>' +
                        '</a>' +
                        '<div class="switch demo3">' +
                        '<input type="checkbox"' + (f.checked ? ' checked' : '') + ' class="selectf">' +
                        '<label><i></i></label>' +
                        '</div>					' +


                        '</li>');

                    folder.appendTo(fileList);
                });

            }

            if (scannedFiles.length) {

                scannedFiles.forEach(function (f) {

                    var fileSize = bytesToSize(f.size),
                        name     = escapeHTML(f.name),
                        fileType = name.split('.'),
                        icon     = '<span class="icon file"></span>';

                    fileType = fileType[fileType.length - 1];

                    icon = '<span class="icon file f-' + fileType + '">.' + fileType + '</span>';

                    // -------------------------------------------------------
                    // added a fancy checkbox to the top of the item
                    // -------------------------------------------------------
                    var file = $('<li class="files"><a href="' + f.path + '" title="' + f.path + '" class="files">' + icon + '<span class="name">' + name + '</span> <span class="details">' + fileSize + '</span><span class="previewText"></span></a>' +
                        '<div class="switch demo3">' +
                        '<input type="checkbox"' + (f.checked ? ' checked' : '') + ' class="selectf">' +
                        '<label><i></i></label>' +
                        '</div>					' +
                        '</li>');
                    file.appendTo(fileList);
                });

            }


            // Generate the breadcrumbs

            var url = '';

            if (filemanager.hasClass('searching')) {

                url = '<span>Search results: </span>';
                fileList.removeClass('animated');

            }
            else {

                fileList.addClass('animated');

                breadcrumbsUrls.forEach(function (u, i) {

                    var name = u.split('/');

                    if (i !== breadcrumbsUrls.length - 1) {
                        url += '<a href="' + u + '"><span class="folderName">' + name[name.length - 1] + '</span></a> <span class="arrow">→</span> ';
                    }
                    else {
                        url += '<span class="folderName">' + name[name.length - 1] + '</span>';
                    }

                });

            }

            breadcrumbs.text('').append(url);


            // Show the generated elements

            fileList.animate({'display': 'inline-block'});

        }


        // This function escapes special html characters in names

        function escapeHTML(text) {
            return text.replace(/\&/g, '&amp;').replace(/\</g, '&lt;').replace(/\>/g, '&gt;');
        }


        // Convert file sizes from bytes to human readable units

        function bytesToSize(bytes) {
            var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            if (bytes == 0) return '0 Bytes';
            var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
            return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
        }

    });
});
