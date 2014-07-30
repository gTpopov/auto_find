
//--- Get Monitor ---
function getMonik() {
    var sr="";
    var n=navigator;
    if (self.screen) {
        sr=screen.width+screen.height;

    } else if (self.java) {
        var j=java.awt.Toolkit.getDefaultToolkit();
        var s=j.getScreenSize();
        sr=s.width+s.height;
    }
    return(sr);
}
$.cookie('__utMonik',getMonik(),{ expires:0, path: '/'});//+
$.cookie('__utDepth',screen.colorDepth,{ expires:0, path: '/'});//+

//------ Flash --------
function getFlash() {
    var f="нет",n=navigator;
    if (n.plugins && n.plugins.length) {
        for (var ii=0;ii<n.plugins.length;ii++) {
            if (n.plugins[ii].name.indexOf('Shockwave Flash')!=-1) {
                f=n.plugins[ii].description.split('Shockwave Flash ')[1];
                break;
            }
        }
    } else if (window.ActiveXObject) {
        for (var ii=10;ii>=2;ii--) {
            try {
                var fl=eval("new ActiveXObject('ShockwaveFlash.ShockwaveFlash."+ii+"');");
                if (fl) { f=ii + '.0'; break; }
            }
            catch(e) {}
        }
    }
    return f;
}
$.cookie('__utFlash',getFlash(),{ expires:0, path: '/'});//+
//------ Java ---
if (navigator.javaEnabled()) {$.cookie('__utJava',1,{ expires:0, path: '/'});}
else {$.cookie('__utJava',0,{ expires:0, path: '/'})};//+
//--- Cookies ---
if (navigator.cookieEnabled) {$.cookie('__utCook',1,{ expires:0, path: '/'});}
else {$.cookie('__utCook',0,{ expires:0, path: '/'})};//+
//--- Platform ---
$.cookie('__utPlat',navigator.platform,{ expires:0, path: '/'});//+
//--- Zone ---
$.cookie('__utZone',-new Date().getTimezoneOffset()/60,{ expires:0, path: '/'});//+
//--- Plagins ---
var arr_pl= null;
for(var i=0;i<navigator.plugins.length;i++) {
    var plugin = navigator.plugins[i];
    var plugin = plugin.name+(plugin.version || '');
    arr_pl +=plugin;
}
$.cookie('__utPlagins',arr_pl,{ expires:0, path: '/'});//+