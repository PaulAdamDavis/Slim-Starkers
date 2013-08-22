// Makes console.log safe to use (no IE errors)
window.console||(console={log:function(){}});

/*!
 * HTML5 Placeholder jQuery Plugin v1.7
 * @link http://github.com/mathiasbynens/Placeholder-jQuery-Plugin
 * @author Mathias Bynens <http://mathiasbynens.be/>
 */
(function(f,z){var e=z in document.createElement('input'),a=z in document.createElement('textarea');if(e&&a){f.fn.placeholder=function(){return this}}else{f.fn.placeholder=function(){return this.filter((e?'textarea':':input')+'['+z+']').bind('focus.'+z,b).bind('blur.'+z,d).trigger('blur.'+z).end()}}function c(h){var g={},i=/^jQuery\d+$/;f.each(h.attributes,function(k,j){if(j.specified&&!i.test(j.name)){g[j.name]=j.value}});return g}function b(){var g=f(this);if(g.val()===g.attr(z)&&g.hasClass(z)){if(g.data(z+'-password')){g.hide().next().show().focus()}else{g.val('').removeClass(z)}}}function d(g){var j,i=f(this);if(i.val()===''||i.val()===i.attr(z)){if(i.is(':password')){if(!i.data(z+'-textinput')){try{j=i.clone().attr({type:'text'})}catch(h){j=f('<input>').attr(f.extend(c(i[0]),{type:'text'}))}j.removeAttr('name').data(z+'-password',true).bind('focus.'+z,b);i.data(z+'-textinput',j).before(j)}i=i.hide().prev().show()}i.addClass(z).val(i.attr(z))}else{i.removeClass(z)}}f(function(){f('form').bind('submit.'+z,function(){var g=f('.'+z,this).each(b);setTimeout(function(){g.each(d)},10)})});f(window).bind('unload.'+z,function(){f('.'+z).val('')})})(jQuery,'placeholder');

$(function(){

    // Make the HTML5 Placeholder option work in older browsers
    $('input, textarea').placeholder();

    /*****
        Class...
    *****/
    var app = {};

    // A sample of how I structure my JS
    // app.something = {
    //      show: function(args){
    //          var elem = args.elem,
    //          message: args.message
    //          elem.show();
    //      console.log(message);
    //      }
    // };

    // app.something.show({
    //  elem: $("#something"),
    //  message: "Some text"
    // });

});
