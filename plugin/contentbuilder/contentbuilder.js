

var ContentBuilder = ContentBuilder || (function ()
{
    /*
    *  드래그 이벤트
    */
    var DragEvent = {
        DRAG_START  : "dragStart",
        DRAG_MOVE   : "dragMove",
        DRAG_END    : "dragEnd"
    };


    /*
    *  블록 이벤트
    */
    var BlockEvent ={
        BLOCK_COPY : "blockCopy",
        BLOCK_DELETE : "blockDelete",
        IMAGE_OVER   : "imageOver",
        IMAGE_OUT   : "imageOut"
    }

    /*
    *  이미지에디터 이벤트
    */
    var ImageEditorEvent ={
        ENTER : "enter",
    }


    /*
    *  템플릿 카테고리
    */
    var tempCategory = [{name:"Default", id:0},{name:"All", id:-1},{name:"Title", id:1},{name:"Title, Subtitle", id:2},{name:"Info, Title", id:3},{name:"Heading, Paragraph", id:5},{name:"Paragraph", id:6},{name:"Buttons", id:33},{name:"Cards", id:34},{name:"Images + Caption", id:9},{name:"Images", id:11},{name:"Single Image", id:12},{name:"Call to Action", id:13},{name:"List", id:14},{name:"Quotes", id:15},{name:"Profile", id:16},{name:"Map", id:17},{name:"Video", id:20},{name:"Social", id:18},{name:"Services", id:21},{name:"Contact Info", id:22},{name:"Pricing", id:23},{name:"Team Profile", id:24},{name:"Products/Portfolio", id:25},{name:"How It Works", id:26},{name:"Partners/Clients", id:27},{name:"As Featured On", id:28},{name:"Achievements", id:29},{name:"Skills", id:32},{name:"Coming Soon", id:30},{name:"Page Not Found", id:31},{name:"Separator", id:19}];


    /*
    *  ImageEditor 클래스
    */
    this.ImageEditor = EventDispatcher.extend(
    {
        container   : null,
        toolBar     : null,
        imgMask     : null,
        targetImage : null,
        startLeft   : 0,
        startTop    : 0,
        addScale    : 1,
        


        init : function ( container )
        {
            this.container = container;
            this.toolBar = this.container.find(".editor_tool");
            this.imgMask = this.container.find(".img_mask");
            this.setToolBar();
        },

        reset : function ()
        {
             this.container.hide();
        },

        setToolBar : function ()
        {
            var owner = this;
            
            this.toolBar.find(".minus_btn").bind("click", function ( e )
            {
                if(owner.addScale > 1)
                {
                    owner.addScale -= 0.1;
                    var scale = parseInt(parseInt(owner.targetImage.attr("min-width")) * owner.addScale);
                    owner.targetImage.css({width:scale});
                    owner.moveImage(owner.targetImage.position().top, owner.targetImage.position().left);
                }
                
            });
            this.toolBar.find(".plus_btn").bind("click", function ( e )
            {
                
                if(owner.addScale < 2)
                {
                    owner.addScale += 0.1;
                    var scale = parseInt(parseInt(owner.targetImage.attr("min-width")) * owner.addScale);
                    owner.targetImage.css({width:scale});
                    owner.moveImage();
                    console.log("!@!@@");
                }
                
            });

            this.toolBar.find(".cancel_btn").bind("click", function ( e )
            {

            });

            this.toolBar.find(".enter_btn").bind("click", function ( e )
            {
                 var canvas = owner.cropImage(owner.targetImage, owner.targetImage.parent().width(), owner.targetImage.parent().height());
                 owner.dispatchEvent({type:ImageEditorEvent.ENTER, vars:{canvas:canvas}});
                 owner.reset();
            });

            this.toolBar.find(".no_crop_btn").bind("click", function ( e )
            {
                owner.reset();
            });
        },

        show : function ( imgTarget, imgPath )
        {
            this.imgMask.css({width:imgTarget.width(), height:imgTarget.height(), top:imgTarget.offset().top, left:imgTarget.offset().left});
            this.targetImage = $('<img src="'+imgPath+'" alt="" style="position:relative;top:0;left:0;height:auto;max-width:none" />');
            this.targetImage.bind("load", function (e)
            {
                $(this).attr("org-width", $(this)[0].width).attr("org-height", $(this)[0].height).attr("min-width", imgTarget.width()).css({"width":imgTarget.width()});
            });
            this.imgMask.empty().append(this.targetImage);
            this.toolBar.css({top:imgTarget.offset().top-40, left:imgTarget.offset().left})
            this.container.show();
            this.dragImage();
            
        }, 
        dragImage : function ()
        {
            var owner = this;
            owner.imgMask.unbind("mousedown", downImageMask);
            owner.imgMask.bind("mousedown", downImageMask);

            function downImageMask( e )
            {
                owner.startLeft = e.pageX-owner.targetImage.position().left;
                owner.startTop  = e.pageY-owner.targetImage.position().top;
                $(window).bind("mousemove", moveImageMask);
                $(window).bind("mouseup", upImageMask);
                e.preventDefault();
            }

            function moveImageMask( e )
            {
                var left = e.pageX - owner.startLeft;
                var top = e.pageY - owner.startTop;
                owner.moveImage(top, left);
                e.preventDefault();
            }

            function upImageMask( e )
            {
                $(window).unbind("mousemove", moveImageMask);
                $(window).unbind("mouseup", upImageMask);
            }
        },
        moveImage : function(top, left)
        {
            var owner = this;
            var maxTop = owner.imgMask.height() - owner.targetImage.height();
            if(maxTop>0)maxTop = 0;
            if(top > 0) top = 0;
            if(top < maxTop) top = maxTop;

            var maxLeft = owner.imgMask.width() - owner.targetImage.width();
            if(maxLeft>0)maxLeft = 0;
            if(left > 0) left = 0;
            if(left < maxLeft) left = maxLeft;

            owner.targetImage.css({left:left, top:top});
        },
        
        cropImage : function ( img, width, height )
        {
            var orgWidth = parseInt(img.attr("org-width"));
            var per = orgWidth /img.width();
            var canvas = $('<canvas width="'+width+'" height="'+height+'" style="position:relative;z-index:9999">');
            $("body").append(canvas);
            var context = canvas[0].getContext('2d');
            context.drawImage(img[0], Math.abs(img.position().left)*per, Math.abs(img.position().top)*per, width*per, height*per, 0, 0, width, height);
            return canvas;
        }

    });

    
    /*
    *  contentBlock 클래스
    */
    this.ContentBlock = EventDispatcher.extend(
    {
        container   : null,
        block       : null,
        tool        : null,        
        id          : null,
        isFocus     : false,

        // init
        init : function (container, block, id)
        {
            this.container = container;
            this.block = block;
            this.id = id;
            this.createTool();
            this.initEvent();
            this.setImage();
        },

        // 제거 
        dispos : function ()
        {
            this.block.unbind("focusin");
            this.block.unbind("focusout");
            this.block.remove();
        },

        // 이벤트 세팅
        initEvent : function ()
        {
            var owner = this;
            var tool
            owner.block.bind("focusin", function ()
            {
                $(this).addClass("ui-dragbox-outlined");
                owner.container.Editor("showMenuBar");
                owner.tool.css({display:"block"});
                owner.isFocus = true; 
            });
            owner.block.bind("focusout", function ()
            {
                owner.block.removeClass("ui-dragbox-outlined");
                owner.container.Editor("hideMenuBar");
                owner.tool.css({display:"none"});
                owner.isFocus = false;
            });
            
        },

        //툴바 생성
        createTool : function ()
        {
            var owner = this;
            owner.tool = $('<div class="block-tool">\
                              <div class="tool-btn move ui-draggable"><i class="fa fa-arrows"></i></div>\
                              <div class="tool-btn add"><i class="fa fa-plus"></i></div>\
                              <div class="tool-btn del" data-toggle="modal" data-target="#deleteModal'+owner.id+'"><i class="fa fa-trash-o"></i></div>\
                          </div>');

            owner.block.append(owner.tool);
            owner.tool.bind("mousedown", function (e)
            {
                e.stopPropagation();
                e.preventDefault();
            });

            owner.container.Editor("createModal", "deleteModal"+owner.id, "삭제", "삭제하시겠습니까?", function ()
            {
                owner.dispatchEvent({type:BlockEvent.BLOCK_DELETE, vars:{target:owner}});
                $("#deleteModal"+owner.id).modal("hide");
                $("#deleteModal"+owner.id).on("bsTransitionEnd", function ( e )
                {
                    $(this).remove();
                });
                
            }, "modal-sm");


            owner.tool.find(".add").bind("click", function ( e )
            {   
                owner.dispatchEvent({type:BlockEvent.BLOCK_COPY, vars:{target:owner}});
            });
        },

        //이미지처리
        setImage : function ()
        {
            var owner = this;

            owner.block.find("img").each(function ( i )
            {
                $(this).bind("mouseenter", function (e)
                {
                    owner.dispatchEvent({type:BlockEvent.IMAGE_OVER, vars:{target:$(this)}});
                });

                $(this).bind("mouseleave", function (e)
                {
                    owner.dispatchEvent({type:BlockEvent.IMAGE_OUT, vars:{target:$(this)}});
                });
            });
        }

    });


    /*
    *  Dragger 클래스
    */
    this.Dragger = EventDispatcher.extend(
    {
        container    : null,
        dragObj      : null,
        dragPosition : {},
        dragTarget   : null,
        startPos     :  {},

        //init
        init : function ( container )
        {
            this.container = container;
            this.createObject();
            this.setDraggable();
        },

        //드래그 객체 생성
        createObject : function ()
        {
            var html = '<div class="drag_obj">\
                        </div>';
            this.dragObj = $(html);
            this.container.append(this.dragObj);

        },

        //드래그 타겟 마우스 이벤트
        setDraggable : function ()
        {
            
            var owner = this;
            var draggable = owner.container.find(".ui-draggable");
            
            draggable.each(function ( i )
            {
                $(this).unbind("mousedown", owner.dragStart);
                $(this).bind("mousedown", {owner:owner}, owner.dragStart);
            });
            
        },


        // 드래그 시작
        dragStart : function ( e )
        {
            var owner = e.data.owner;
            $(window).bind("mousemove", {owner:owner}, owner.dragMove);
            $(window).bind("mouseup", {owner:owner}, owner.dragEnd);
            owner.dragObj.addClass("drag");   
            owner.dragTarget = $(this);
            var pos = {left:e.pageX, top:e.pageY};
            owner.startPos = pos;
            owner.dragPosition = {x:pos.left - owner.dragTarget.offset().left, y:pos.top - owner.dragTarget.offset().top};
            owner.moveDragObject(owner.dragTarget, pos); 
            owner.dispatchEvent({type:DragEvent.DRAG_START, vars:{target:owner.dragTarget, position:pos}});
            //e.preventDefault();
            //e.stopPropagation();
        },

        // 드래그 이동
        dragMove : function ( e )
        {
            var owner = e.data.owner;
            var pos = {left:e.pageX, top:e.pageY};
            owner.moveDragObject(owner.dragTarget, pos);
            var area = owner.checkDragArea(owner.dragTarget, pos);
            var arrow;
            if(owner.startPos.top < pos.top)        arrow = 1;
            else if(owner.startPos.top > pos.top)   arrow = -1;
            else                                arrow = 0;
            owner.dispatchEvent({type:DragEvent.DRAG_MOVE, vars:{area:area, target:owner.dragTarget, position:pos, arrow:arrow}});
            owner.startPos = pos; 
            e.preventDefault();
            e.stopPropagation();
        },

        // 드래그 종료
        dragEnd : function ( e )
        {
            var owner = e.data.owner;
            $(window).unbind("mousemove", owner.dragMove);
            $(window).unbind("mouseup", owner.dragEnd);
            owner.dragObj.removeClass("drag");
            var pos = {left:e.pageX, top:e.pageY};
            var area = owner.checkDragArea(owner.dragTarget, pos);
            owner.dispatchEvent({type:DragEvent.DRAG_END, vars:{area:area, target:owner.dragTarget, position:pos}});
            owner.dragTarget = null;
            owner.dragObj.empty();
        },

        // 드래그 객체 이동
        moveDragObject : function ( target, position )
        {
            var winTop = $(window).scrollTop();
            this.dragObj.css({top:position.top - winTop - this.dragPosition.y, left:position.left - this.dragPosition.x});
        },

        // 드래그 영역 체크
        checkDragArea : function ( target, position )
        {
            var areas =  this.container.find(".ui-drag-area");
            for(var i=0; i<areas.length; i++)
            {
                var area = areas.eq(i);
                var rect = {
                    x:area.offset().left, 
                    y:area.offset().top, 
                    w:area.width()+parseInt(area.css("padding-left"))+parseInt(area.css("padding-right")), 
                    h:area.height()+parseInt(area.css("padding-top"))+parseInt(area.css("padding-bottom"))
                };

                if(area.is(".content_area")) rect.h = 112;
                if(position.left > rect.x && position.left < rect.x + rect.w && position.top > rect.y && position.top < rect.y + rect.h)
                {
                    return area;
                }
            }
            return null
        }

    });


    /*
    *  ContentBuilder 생성자
    */
    return Class.extend(
    {
        container     : null,
        contentArea   : null,
        tempTool      : null,
        tempFile      : null,
        tempSource    : null,
        dragger       : null,
        contentBlocks : [],
        contentCount  : 0,
        deleteModal   : null,
        imageTool     : null,
        imageEditor   : null,
        targetImage   : null,


        // init
        init : function ( containerID, option )
        {
            this.container = $(containerID);

            var pattern = /tempFile/;

            for( var opt in option)
            {
                if(option[opt])
                {
                    if(pattern.test(opt)) this[opt] = option[opt];
                }
            }

            var owner = this; 
            owner.contentArea = $('<div class="content_area"></div>');
            owner.container.append(owner.contentArea);
            owner.container.Editor();
            owner.initDragger();
            owner.initContentBlock();
            owner.createTempTool();
            owner.createImageEditor();
            owner.createImageTool();

            // 드래그 생성
            
        },

        // 드래거 init
        initDragger : function ()
        {
            var owner = this;
            owner.dragger = new Dragger( owner.container );
            owner.dragger.addEventListener(DragEvent.DRAG_START, function ( e )
            {
                var target = e.vars.target;
                if(target.is(".ui-drag-list"))
                {
                    appendDragThumb(target);
                }
                else if(target.is(".tool-btn"))
                {
                    moveDragBlock(target);
                }
            });

            owner.dragger.addEventListener(DragEvent.DRAG_MOVE, function ( e )
            {
                if(e.vars.area)
                {
                    if(e.vars.area.is(".content_empty"))
                    {
                        $(".content_empty").css({"background-color":"rgba(0,0,0,0.01)"});  
                    }
                    else if(e.vars.area.is(".ui-drag-area"))
                    {
                        if(e.vars.arrow < 0)
                        {
                            e.vars.area.addClass("ui-add-up");
                            e.vars.area.removeClass("ui-add-down");
                        }
                        else if(e.vars.arrow < 1)
                        {
                            e.vars.area.removeClass("ui-add-up");
                            e.vars.area.addClass("ui-add-down");
                        }
                    }
                }
                else
                {
                    $(".content_empty").css({"background-color":""});
                    $(".ui-drag-block").removeClass("ui-add-up");
                    $(".ui-drag-block").removeClass("ui-add-down");
                }
            });

            owner.dragger.addEventListener(DragEvent.DRAG_END, function ( e )
            {
                var target = e.vars.target;
                if(target.is(".ui-drag-list"))
                {
                    target.find("img").css({opacity:""});
                }
                $(".content_empty").css({"background-color":""});

                if(e.vars.area)
                {
                    if(target.is(".ui-drag-list"))
                    {
                        if(e.vars.area.is(".content_empty"))
                        {
                            owner.createContentBlock(null, e.vars.target.attr("data-num"));
                            owner.contentArea.removeClass("content_empty").removeClass("ui-drag-area");
                            owner.dragger.setDraggable();
                        }
                        else if(e.vars.area.is(".ui-drag-area"))
                        {
                            owner.createContentBlock(e.vars.area, e.vars.target.attr("data-num"));
                        }
                    }
                }
                
                $(".ui-drag-block").removeClass("ui-add-up");
                $(".ui-drag-block").removeClass("ui-add-down");
                $(".ui-drag-block").css({display:"block"});

            });

            // 드레그 이미지 추가
            function appendDragThumb( target )
            {
                var thumb = target.find("img").clone();
                target.find("img").css({opacity:0.8});
                owner.dragger.dragObj.append(thumb);
            }

            function moveDragBlock(target)
            {
                var block = target.parent().parent();
                var copy = block.clone();
                copy.removeClass("ui-drag-block").removeClass("ui-drag-area").css({width:block.width()}); 
                owner.dragger.dragObj.append(copy);
                target.parent().parent().css({display:"none"});
            }
        },

        // 콘텐츠 블록 init
        initContentBlock : function ()
        {
            var owner = this;
            var blocks = owner.contentArea.find(">div");

            if(blocks.length == 0)
            {
               owner.contentArea.addClass("content_empty").addClass("ui-drag-area"); 
            }
        },

        // 콘텐츠 블록 생성
        createContentBlock : function (target, dataNum, source)
        {
            var owner = this;
            var blockHtml;

            if(dataNum == null)
            {
                $(source).find(".block-tool").remove();
                blockHtml = $(source)[0].outerHTML;
            }
            else
            {
                blockHtml = owner.findContentBlock( dataNum );
            }

            
            if(blockHtml)
            {
                var block = $('<div id="content-block-'+owner.contentCount+'" class="ui-drag-block ui-drag-area" data-num="'+dataNum+'"></div>');
                if(target == null)
                {
                    owner.contentArea.append(block);
                }
                else
                {
                    if(target.is(".ui-add-up"))
                    {
                        target.before(block);
                    }
                    else if(target.is(".ui-add-down"))
                    {
                        target.after(block);
                    }
                }
                block.append(blockHtml);
                block.find(">div>div").attr("contenteditable", true);

                var contentBlock = new ContentBlock(owner.container, block, owner.contentCount);

                contentBlock.addEventListener(BlockEvent.BLOCK_COPY, function ( e )
                {
                    e.vars.target.block.addClass("ui-add-down");
                    owner.createContentBlock(e.vars.target.block, null, e.vars.target.block.html());
                    e.vars.target.block.removeClass("ui-add-down");
                });

                contentBlock.addEventListener(BlockEvent.BLOCK_DELETE, function ( e )
                {
                   owner.deleteContentBlock(e.vars.target);
                });

                contentBlock.addEventListener(BlockEvent.IMAGE_OVER, function ( e )
                {
                    var imgTarget = e.vars.target;
                    owner.imageTool.css({top:imgTarget.offset().top+(imgTarget.height()/2)-25, left:imgTarget.offset().left+(imgTarget.width()/2)});
                    owner.imageTool.show();
                    owner.targetImage = imgTarget;
                });

                contentBlock.addEventListener(BlockEvent.IMAGE_OUT, function ( e )
                {
                    owner.imageTool.hide();
                });

                owner.contentBlocks.push( contentBlock );
                owner.contentCount++;
                owner.dragger.setDraggable();
            }
        },

        // 콘텐츠 블록 삭제
        deleteContentBlock : function ( block )
        {
            var tempBlock = new Array();
            for(var i = 0; i<this.contentBlocks.length; i++)
            {
                var contentBlock = this.contentBlocks[i];
                if(block == contentBlock)
                {
                    contentBlock.dispos();
                    contentBlock.removeEventListener(BlockEvent.BLOCK_DELETE);
                    contentBlock.removeEventListener(BlockEvent.BLOCK_COPY);
                    contentBlock = null;
                }
                else
                {
                    tempBlock.push(contentBlock);
                }
            }
            this.contentBlocks = tempBlock;
            this.initContentBlock();
            this.container.Editor("hideMenuBar");
            this.dragger.setDraggable();
        },


        // 콘텐츠 블록 찾기
        findContentBlock : function ( dataNum )
        {
            var blocks = this.tempSource.find(">div").parent();
            for(var i = 0; i<blocks.length; i++)
            {
                var block = blocks.eq(i);
                if(block.attr("data-num") == dataNum)
                {
                    return block.html();
                }
            }
            return null;
        },


        // 템플릿툴 생성
        createTempTool : function ()
        {
            var owner = this;
            var tempHtml = '<div class="temp_tool show">\
                                <a class="button" href="javascript:"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>\
                                <select class="temp_select form-control"></select>\
                                <div class="temp_list"></div>\
                            </div>';
                            
            owner.tempTool = $(tempHtml);
            owner.container.append(owner.tempTool);
            owner.tempTool.find(".button").bind("click", function( e )
            {
               if(owner.tempTool.is(".hide"))
               {
                   owner.tempTool.removeClass("hide");
               } 
               else
               {
                   owner.tempTool.addClass("hide");
               }
            });

            owner.tempTool.bind("dragstart", function ( e )
            {
                e.preventDefault();
                e.stopPropagation();
                return false;
            });

            owner.tempTool.bind("selectstart", function ( e )
            {
                e.preventDefault();
                e.stopPropagation();
                return false;
            });

            $(window).bind("resize", function ( e )
            {
                owner.tempTool.find(".temp_list").css({height:$(window).height()-80});
            });

            $(window).resize();
            owner.loadTemplate();

        },

        //템플릿 파일 로드
        loadTemplate : function ()
        {
            var owner = this;
            $.get(owner.tempFile, function ( data )
            {
                owner.tempSource = $(data);
                var list = owner.tempSource.find(">div").parent(); 
                list.each( function ( i )
                {
                    var imgPath = $(this).attr("data-thumb");
                    var dataNum = $(this).attr("data-num");
                    var dataCat = $(this).attr("data-cat");
                    var listHtml = '<div class="ui-draggable ui-drag-list" data-num="'+ dataNum +'" data-cat="'+ dataCat +'">\
                                        <img src="'+imgPath+'" />\
                                    </div>';
                    owner.tempTool.find(".temp_list").append(listHtml);
                });
                
                owner.setSelectBox();
                owner.sortTemplete(0);
                owner.dragger.setDraggable();
            });  
        }, 

        //카테고리 셀렉박스 세팅
        setSelectBox : function ()
        {
            var owner = this;

            for(var i=0; i<tempCategory.length; i++)
            {
                var item = tempCategory[i];
                var option = $('<option value="'+item.id+'">' + item.name + '</option>');
                owner.tempTool.find(".temp_select").append(option);
            }

            owner.tempTool.find(".temp_select").bind("change", function ( e )
            {
                var id = $(this).find("option:selected").val();
                owner.sortTemplete(id);
            });
        },

        // 카테고리 정렬
        sortTemplete : function ( id )
        {
            var owner = this;
            var list = owner.tempTool.find(".temp_list>div"); 
            list.each(function ( i )
            {
                if(id != -1)
                {
                    if($(this).attr("data-cat").indexOf(id) > -1)   $(this).css({display:"inline-block"});
                    else                                            $(this).css({display:"none"});
                }
                else
                {
                    $(this).css({display:"inline-block"});
                }
            });
        },

        // 이미지에디터 생성
        createImageEditor : function ()
        {
            var owner = this;
            var imageEdiorHtml = '<div class="img_editor">\
                                        <div class="img_mask">\
                                        </div>\
                                        <div class="editor_tool">\
                                            <button class="btn btn-sm btn-default minus_btn"><i class="fa fa-minus"></i></button>\
                                            <button class="btn btn-sm btn-default plus_btn"><i class="fa fa-plus"></i></button>\
                                            <button class="btn btn-sm btn-danger cancel_btn"><i class="fa fa-ban"></i> 취소</button>\
                                            <button class="btn btn-sm btn-primary enter_btn"><i class="fa fa-check"></i> 확인</button>\
                                            <button class="btn btn-sm btn-success no_crop_btn"><i class="fa fa-check"></i> 편집없이 적용</button>\
                                        </div>\
                                  </div>';

            var imgEditor = $(imageEdiorHtml);
            owner.imageEditor = new ImageEditor(imgEditor);
            owner.container.append(imgEditor);
            owner.imageEditor.addEventListener(ImageEditorEvent.ENTER, function ( e )
            {
                //owner.targetImage.parent().empty().append(e.vars.obj);
                owner.uploadImage(e.vars.canvas);
            });
        },

        // 이미지툴바 생성
        createImageTool : function ()
        {
            var owner = this;
            var imageToolHtml = '<div class="img_tool">\
                                    <span class="upload_btn"><input id="imgUploadFile" name="userfile" type="file"></span>\
                                    <button type="button" class="link_btn"></button>\
                                  </div>';

            owner.imageTool = $(imageToolHtml);
            owner.container.append(owner.imageTool);

            owner.imageTool.bind("mouseover", function (e)
            {
                $(this).show();
            });

            owner.imageTool.bind("mouseout", function (e)
            {
                $(this).hide();
            });

            owner.imageTool.find("input[type='file']").bind("change", function ( e )
            {
                var file = $(this)[0].files[0];
                var reader = new FileReader();
                if (file) 
                {
                    reader.readAsDataURL(file);
                }

                reader.addEventListener("load", function ()
                {
                    owner.imageEditor.show(owner.targetImage, reader.result);
                });

                //owner.uploadImage();
            });
        },

        // 이미지 업로드
        uploadImage : function (canvas)
        {
            var owner = this;
            var dataURL = canvas[0].toDataURL();
           

            $.ajax({
                type : "POST",
                url  : "/editorfileupload/contentbuilder",
                data : {
                    imageData : dataURL,
                    csrf_test_name : cb_csrf_hash 
                }
            })
            .done(function (data)
            {
                console.log(data);
                var result = $.parseJSON(data);
                if(result.status == "success")
                {
                    owner.targetImage.attr("src", result.url);
                }
                else
                {
                    alert("파일업로드 에러");
                }
                canvas.remove();
            });
        },

        // html 출력
        getHtml : function ()
        {
            var owner = this;    
            var output = "";
            this.container.find(".content_area").find(">div").each(function ( i )
            {
                $(this).find(".block-tool").remove();
                $(this).find("div").attr("contenteditable", null);
                var dataNum = $(this).attr("data-num");
                var blockHtml = '<div data-num="'+dataNum+'">';
                blockHtml += $(this).html();
                blockHtml += '</div>';
                output +=  blockHtml;
            });

            return output;
            
        }
    });
    
})();
