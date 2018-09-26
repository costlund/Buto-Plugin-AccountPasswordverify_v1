function PluginAccountPasswordverify_v1(){
  this.data = {method: null}
  this.verify = function(method){
    this.data.method = method;
    PluginWfBootstrapjs.modal({id: 'modal_passwordverify', url:'passwordverify/verify', lable:PluginI18nJson_v1.i18n('Verify'), size:'sm'});
  }
  this.verify_capture = function(result){
    if(result){
      $('#modal_passwordverify').modal('hide');
      this.run_method();
    }else{
      alert(PluginI18nJson_v1.i18n('Wrong password!'));
    }
  }
  this.run_method = function(){
    var method = PluginAccountPasswordverify_v1.data.method;
    method();
  }
}
var PluginAccountPasswordverify_v1 = new PluginAccountPasswordverify_v1();
