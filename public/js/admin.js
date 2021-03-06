var Molsen = (function(window) {
    var Molsen = function(name) {
        return new Molsen.fn.init(name);
    }

    Molsen.fn = Molsen.prototype = {
        constructor: Molsen,
        init: function(name) {
            this.name = name;
            this.sayHello = function() {
                this.makeArray();
            }
        },
        makeArray: function() {
            console.log(this.name);
        },
        // type: success danger warning info
        alert: function(id, type, msg, callback=function(){}) {
            var title = type=='success' ? '成功' : '失败';
            $(id).prepend('<div class="alert alert-'+type+'" role="alert">' + 
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' + 
            '<span aria-hidden="true">&times;</span></button><strong>'+title+'!</strong> '+msg+'</div>');
            setTimeout(function() {
              $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
                callback();
              });
            }, 1000);
        }
    }

    Molsen.fn.init.prototype = Molsen.fn;

    return Molsen;
})();

var molsen = Molsen('admin');