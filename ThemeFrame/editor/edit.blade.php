@extends('commons.fresns')

@section('title', fs_db_config('menu_editor_functions'))

@section('content')
    <div class="container-fluid">
        <div class="fresns-editor">
            <form action="{{ fs_route(route('fresns.editor.publish', [$type, $draft['detail']['id']])) }}" method="post">
                @csrf
                @method("post")
                <input type="hidden" name="type" value="{{ $type ?? '' }}" />
                <input type="hidden" name="postGid" value="{{ $group['gid'] ?? '' }}" />

                {{-- Tip: Publish Permissions --}}
                @if ($config['publish']['limit']['status'] && $config['publish']['limit']['isInTime'])
                    @component('components.editor.tip.publish', [
                        'config' => $config['publish'],
                    ])@endcomponent
                @endif

                {{-- Tip: Edit Timer --}}
                @if ($draft['edit']['isEdit'])
                    @component('components.editor.tip.edit', [
                        'config' => $draft['edit'],
                    ])@endcomponent
                @endif

                {{-- Group --}}
                @if ($config['editor']['features']['group']['status'])
                    @component('components.editor.section.group', [
                        'config' => $config['editor']['features']['group'],
                        'group' => $group,
                    ])@endcomponent
                @endif

                {{-- Toolbar --}}
                @component('components.editor.section.toolbar', [
                    'type' => $type,
                    'plid' => $plid,
                    'clid' => $clid,
                    'config' => $config['editor']['toolbar'],
                    'stickers' => $stickers,
                    'uploadInfo' => $uploadInfo,
                ])@endcomponent

                {{-- Content Start --}}
                <div class="editor-content p-3">
                    {{-- Title --}}
                    @if ($config['editor']['toolbar']['title']['status'])
                        @component('components.editor.section.title', [
                            'config' => $config['editor']['toolbar']['title'],
                            'title' => $draft['detail']['title'],
                        ])@endcomponent
                    @endif

                    {{-- Content --}}
                    <textarea class="form-control rounded-0 border-0 fresns-content" name="content" id="content" rows="10" placeholder="{{ fs_lang('editorContent') }}">{{ $draft['detail']['content'] }}</textarea>

                    {{-- Files --}}
                    @component('components.editor.section.files', [
                        'type' => $type,
                        'files' => $draft['detail']['files'],
                        'fileCount' => $draft['detail']['fileCount'],
                    ])@endcomponent

                    {{-- Extends --}}
                    @component('components.editor.section.extends', [
                        'type' => $type,
                        'extends' => $draft['detail']['extends'],
                    ])@endcomponent

                    {{-- Allow Info --}}
                    @if ($draft['detail']['allowJson'])
                        @component('components.editor.section.allow', [
                            'type' => $type,
                            'allow' => $draft['detail']['allowJson'],
                        ])@endcomponent
                    @endif

                    {{-- Comment with button settings --}}
                    @if ($draft['detail']['commentBtnJson'])
                        @component('components.editor.section.comment-btn', [
                            'type' => $type,
                            'commentBtn' => $draft['detail']['commentBtnJson'],
                        ])@endcomponent
                    @endif

                    {{-- Post User List Configuration --}}
                    @if ($draft['detail']['userListJson'])
                        @component('components.editor.section.user-list', [
                            'type' => $type,
                            'userList' => $draft['detail']['userListJson'],
                        ])@endcomponent
                    @endif

                    <hr>

                    {{-- Location and Anonymous Start --}}
                    <div class="d-flex bd-highlight align-items-center">
                        {{-- Location --}}
                        @if ($config['editor']['features']['location']['status'] && $config['editor']['features']['location']['maps'])
                            @component('components.editor.section.location', [
                                'type' => $type,
                                'config' => $config['editor']['features']['location'],
                                'location' => $draft['detail']['mapJson'],
                            ])@endcomponent
                        @endif

                        {{-- Anonymous --}}
                        @if ($config['editor']['features']['anonymous'])
                            @component('components.editor.section.anonymous', [
                                'type' => $type,
                                'isAnonymous' => $draft['detail']['isAnonymous'],
                            ])@endcomponent
                        @endif
                    </div>
                    {{-- Location and Anonymous End --}}
                </div>
                {{-- Content End --}}

                {{-- Button --}}
                <div class="editor-submit d-grid">
                    <button type="submit" class="btn btn-success btn-lg my-5 mx-3">
                        @if ($type == 'post')
                            {{ fs_db_config('publish_post_name') }}
                        @endif
                        @if ($type == 'comment')
                            {{ fs_db_config('publish_comment_name') }}
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Upload Modal --}}
    <div class="modal fade" id="fresns-upload" tabindex="-1" aria-labelledby="fresns-upload" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ fs_lang('editorUpload') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="mt-2" method="post" id="upload-form" multiple="true" enctype="multipart/form-data">
                        <input type="hidden" name="usageType" @if($type === 'post') value="7" @elseif($type === "comment") value="8" @endif>
                        <input type="hidden" name="tableName" @if($type === 'post') value="post_logs" @elseif($type === "comment") value="comment_logs" @endif>
                        <input type="hidden" name="tableColumn" value="id">
                        <input type="hidden" name="tableId" value="{{ $draft['detail']['id'] ?? '' }}">
                        <input type="hidden" name="uploadMode" value="file">
                        <input type="hidden" name="type">
                        <input class="form-control" type="file" id="formFile">
                        <label class="form-label mt-3 ms-1 text-secondary text-break fs-7 d-block">{{ fs_lang('editorUploadExtensions') }}: <span id="extensions"></span></label>
                        <label class="form-label mt-1 ms-1 text-secondary text-break fs-7 d-block">{{ fs_lang('editorUploadMaxSize') }}: <span id="maxSize"></span> MB</label>
                        <label class="form-label mt-1 ms-1 text-secondary text-break fs-7 d-block" id="maxTimeDiv">{{ fs_lang('editorUploadMaxTime') }}: <span id="maxTime"></span> {{ fs_lang('unitSecond') }}</label>
                        <label class="form-label mt-1 ms-1 text-secondary text-break fs-7 d-block">{{ fs_lang('editorUploadNumber') }}: <span id="maxNumber"></span></label>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="ajax-upload">{{ fs_lang('editorUploadBtn') }}</button>
                    <div class="progress w-100 d-none" id="upload-progress"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function addEditorAttachment(fileinfo) {
            let html;

            if (fileinfo.type === 1) {
                html = `
                <div class="position-relative">
                    <img src="${fileinfo.imageSquareUrl}" class="img-fluid">
                    <div class="position-absolute top-0 end-0 editor-btn-delete">
                        <button type="button" class="btn btn-outline-dark btn-sm rounded-0 border-0" data-fid="${fileinfo.fid}" onclick="deleteFile(this)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ fs_lang('delete') }}" title="{{ fs_lang('delete') }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>`;

                $(".editor-file-image").append(html);
                let imgLength = $(".editor-file-image").find(".position-relative").length
                $(".editor-file-image").removeClass().addClass("editor-file-image editor-file-image-"+ imgLength +" mt-3 clearfix")
            }
            if (fileinfo.type === 2) {
                var videoImage = ''
                if (fileinfo.videoGifUrl) {
                    videoImage = `<img src="${fileinfo.videoGifUrl}" class="img-fluid">`
                } else if (fileinfo.videoCoverUrl) {
                    videoImage = `<img src="${fileinfo.videoCoverUrl}" class="img-fluid">`
                } else {
                    videoImage = `<svg class="bd-placeholder-img rounded" xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96"></rect></svg>`
                }
                html = `
                <div class="position-relative">
                    ${videoImage}
                    <div class="position-absolute top-0 end-0 editor-btn-delete">
                        <button type="button" class="btn btn-outline-dark btn-sm rounded-0 border-0" data-fid="${fileinfo.fid}" onclick="deleteFile(this)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ fs_lang('delete') }}" title="{{ fs_lang('delete') }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <button type="button" class="btn btn-light editor-btn-video-play" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ fs_lang('editorVideoPlay') }}" title="{{ fs_lang('editorVideoPlay') }}">
                            <i class="bi bi-play-fill"></i>
                        </button>
                    </div>
                </div>`
                $(".editor-file-video").append(html);
            }
            if (fileinfo.type === 3) {
                html = `
                <div class="position-relative">
                    <audio src="${fileinfo.audioUrl}" controls="controls" preload="meta" controlsList="nodownload" oncontextmenu="return false">
                        Your browser does not support the audio element.
                    </audio>
                    <div class="position-absolute top-0 end-0 editor-btn-delete">
                        <button type="button" class="btn btn-outline-dark btn-sm rounded-0 border-0" data-fid="${fileinfo.fid}" onclick="deleteFile(this)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ fs_lang('delete') }}" title="{{ fs_lang('delete') }}">
                            <i class="bi bi-trash"></i>
                        </button></div>
                </div>`
                $('.editor-file-audio').append(html);
            }
            if(fileinfo.type === 4) {
                html = `
                <div class="position-relative">
                    <div class="editor-document-box">
                        <div class="editor-document-icon">
                            <i class="bi bi-file-earmark"></i>
                        </div>
                        <div class="editor-document-name text-nowrap overflow-hidden">${fileinfo.name}</div>
                    </div>
                    <div class="position-absolute top-0 end-0 editor-btn-delete">
                        <button type="button" class="btn btn-outline-dark btn-sm rounded-0 border-0" data-fid="${fileinfo.fid}" onclick="deleteFile(this)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ fs_lang('delete') }}" title="{{ fs_lang('delete') }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>`
                $(".editor-file-document").append(html);
            }
        }

        window.onmessage = function (event) {
            var data = event.data;
            console.log('Fresns Plugin Message', data);

            if (data.code != 0) {
                if (data.message) {
                    window.tips(data.message);
                }
                return
            }

            switch (data.postMessageKey) {
                case "fresnsEditorUpload":
                    console.log('Fresns Plugin Data', data.data)

                    data.data.forEach(fileinfo => {
                        addEditorAttachment(fileinfo);
                    });

                    if (data.windowClose) {
                        // Close plugin window
                        $('#done-extensions').click()
                    }
                break;

                case "fresnsEditorExtension":
                    console.log('Fresns Plugin Data', data.data)

                    if (data.windowClose) {
                        window.location.refresh()
                    }
                break;
            }
        };

        const postDraft = function (title, content, fid = ''){
            $.post("{{ route('fresns.api.editor.update', ['type' => $type, 'draftId' => $draft['detail']['id']]) }}", {
                'content':  content,
                'postTitle' : title,
                'postGid' : "{{ $draft['detail']['group']['gid'] ?? null }}",
                'request_token' : "{{ \Illuminate\Support\Facades\Cookie::get('token') }}",
                'deleteFile': fid
            }, function (data){
                console.log(data)
            })
        };

        function deleteFile(obj) {
            $(obj).parent().parent().remove();
            let fid = $(obj).data('fid'),
                content = $("#content").val(),
                title = $("#title").val();
            postDraft(title, content, fid);
        }

        (function($){
            let fileUploadModal = document.getElementById('fresns-upload');
            fileUploadModal.addEventListener('show.bs.modal', function (event) {
                let button = event.relatedTarget,
                    extensions = $(button).data('extensions'),
                    type = $(button).data('type'),
                    accept = $(button).data('accept'),
                    maxSize = $(button).data('maxsize');
                    maxTime = $(button).data('maxtime') ?? 0;
                    maxNumber = $(button).data('maxnumber');

                if ($.inArray(type, ['document', 'image']) >= 0 ) {
                    $("#formFile").attr('multiple', 'multiple')
                } else {
                    $("#formFile").removeAttr('multiple')
                }

                if (maxTime == 0) {
                    $(this).find("#maxTimeDiv").addClass('d-none');
                } else {
                    $(this).find("#maxTimeDiv").removeClass('d-none');
                }

                $("#formFile").prop('accept', accept)
                $("#extensions").text(extensions);
                $("#maxSize").text(maxSize);
                $("#maxTime").text(maxTime);
                $("#maxNumber").text(maxNumber);
                $("#fresns-upload input[name='type']").val(type);
            })

            let content, title;

            setInterval(function (){
                content = $("#content").val();
                title = $("#title").val();
                postDraft(title, content);
            }, 10000);


            $(".fresns-sticker").on('click',function (){
                $("#content").trigger('click').insertAtCaret("[" + $(this).attr('value') + "]");
            });

            $("#fresns-upload").on('show.bs.modal', function () {
                $(this).find('#ajax-upload').show().removeAttr("disabled");
                $(this).find('#formFile').val("");
                $(this).find("#upload-progress").addClass('d-none').empty();
            })

            $("#ajax-upload").on('click', function (event){
                event.preventDefault();
                let obj = $(this),
                    maxSize = 0,
                    form = new FormData(document.getElementById("upload-form"))

                let files = $('#formFile').prop('files');

                for (let i = 0; i < files.length; i++) {
                    form.append('files[]', files[i])
                    maxSize += files[i].size;
                }

                if (maxSize > $("#maxSize").text() * 1024 * 1024) {
                    alert("{{ fs_lang('editorUploadMaxSize') }}: " + $("#maxSize").text() + "MB");
                    return;
                }

                if (obj.is(":disabled")) {
                    return;
                }
                if (!$("#formFile").val()) {
                    alert("{{ fs_lang('editorUploadInfo') }}");
                    return;
                }

                obj.attr('disabled', true);
                obj.hide();

                // set progress
                progress.init().setParentElement(obj.next('.progress').removeClass('d-none')).work();

                $.ajax({
                    url: "{{ route('fresns.api.editor.upload.file') }}",
                    type:"POST",
                    data: form,
                    timeout: 600000,
                    processData: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    success: function(resp) {
                        progress.done();
                        if (resp.code === 0) {
                            resp.data.forEach(function (res){
                                addEditorAttachment(res);
                            })
                        } else {
                            tips(resp.message, resp.code)
                        }
                        $("#fresns-upload .btn-close").trigger('click');
                    },
                    error: function(e) {
                        progress.exit();
                        tips(e.responseJSON.message)
                        $("#fresns-upload .btn-close").trigger('click');
                    },
                });
            })
        })(jQuery);
    </script>
@endpush
