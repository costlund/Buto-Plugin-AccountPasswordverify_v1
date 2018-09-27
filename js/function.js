function PluginAccountPasswordverify_v1(){
  this.data = {method: null, params: {}}
  this.verify = function(method, params){
    this.data.method = method;
    this.data.params = params;
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
    var params = PluginAccountPasswordverify_v1.data.params;
    method(params);
  }
}
var PluginAccountPasswordverify_v1 = new PluginAccountPasswordverify_v1();
