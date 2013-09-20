function show_pop_box_url(url){
  $.get(url,function(data){
    $('body').append(data);
  });
}
/**
 * 显示一个弹出框
 * [opt] string body of box | object
 * [opt.title] string title of box
 * [opt.body] string body of box
 * [opt.footer] boolean footer of box
 * [opt.id] id of box
 * [opt.onclose] function callback of close
 * [opt.onok] function callback of ok
 * [opt.closebox] boolean close box auto
 */
function show_pop_box(opt){
  if(typeof(opt) == 'undefined'){
    opt={};
    opt.body = '';
    opt.title = "系统消息";
  }else if(typeof(opt)=='string'){
    var t = opt;
    opt = {};
    opt.title = "系统消息";
    opt.body = t;
  }
  if(opt.title == undefined)
    opt.title = "系统消息";
  if(opt.body == undefined)
    opt.body = "";
  if(opt.id == undefined) 
    opt.id = 'myPopBox';
  if(opt.onclose == undefined)
    opt.onclose = function(){close_pop_box(opt.id)};
  if(opt.onok == undefined)
    opt.onok = function(){close_pop_box(opt.id)};
  close_pop_box(opt.id);
  var box = '<div id="'+opt.id+'" class="modal"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">×</button><h3 id="myPopBoxLabel">'+opt.title+'</h3></div><div class="modal-body">'+opt.body+'</div><div class="modal-footer"><button id="box_ok" class="btn btn-primary">确定</button><button class="btn" data-dismiss="modal">关闭</button></div></div>';

  var box=$(box);

  $('body').append(box);
  $('#'+opt.id).on('hidden',function(){
    $('#'+opt.id).remove();
    opt.onclose();
  }).modal({
    backdrop:'static',
    keyboard:false
  }).modal('show');
  $('#box_ok').click(opt.onok);
  if(opt.closebox == true)
    setTimeout(close_pop_box,2000,opt.id,opt.onclose);
}

function close_pop_box(box_id, callback){
  if(box_id ==undefined) 
    box_id = 'myPopBox';
  if(callback != undefined && typeof(callback)=='function')
    callback();
  $('#'+ box_id).modal('hide');
  $('#' + box_id).remove();
}

