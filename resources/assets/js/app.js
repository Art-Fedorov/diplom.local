

var testForm = require('./components/create/test_form.vue');
var questionForm = require('./components/create/question_form.vue');
var testSidebar=  require('./components/create/test_sidebar.vue');
var testView= require('./components/create/test_view.vue');
var testPublish= require('./components/create/test_publish.vue');
var testInfo = require('./components/create/test_info.vue');
var results = require('./components/create/results.vue');
var groups = require('./components/create/groups.vue');
var users = require('./components/create/users.vue');
var addGroups = require('./components/create/add_groups.vue');
var popup = require('./components/popup.vue');

import { VueEditor } from 'vue2-editor';

var testInstance = new Vue({
    el: '#app',
    data: {
      current:{
        mainView: 'test-form',
        array: {title:'add'}
      },
      previous:[],
      showed: true,
      idUser: null,
      showSidebar: true,
      showPopup: false,
      popup: {
        header: null,
        body: null
      },
      xxx: 0,
      testContent: '<p>asd</p>',
      customToolbar: [
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block','image'],

            [{ 'list': 'ordered'}, { 'list': 'bullet' }],

            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

            [{ 'color': [] }, { 'background': [] }],
            [{ 'font': [] }],

            ['clean']
          ],

    },
    created: function(){
      this.getUserId();
    },
    components: {
      'test-form': testForm,
      'question-form': questionForm,
      'test-sidebar': testSidebar,
      'test-view': testView,
      'test-publish': testPublish,
      'test-info': testInfo,
      'results': results,
      'groups': groups,
      'users': users,
      'popup': popup,
      'vue-editor': VueEditor,
      'add-groups': addGroups
    },
    watch: {
      current(val){

      }
    },
    methods: {
      showTestContent(){
        this.xxx++;
        console.log(this.xxx,this.testContent);
      },
      showPopupDelay(ms){
        let self=this;
        self.showPopup=true;
        setTimeout(function(){
          self.closePopup();
        },ms);
      },
      closePopup(){
        this.showPopup=false;
        this.popup={
          header: null,
          body: null
        };
      },
      switchMainView: function(view,ar = {}){
        if (this.current.mainView!=view||!isEqual(this.current.array,ar)){
          if (this.current.mainView!=view){
            this.previous.push(clone(this.current));
          }
          this.current.mainView=view;
          if (Object.keys(ar).length>0){
            this.current.array=ar;
          }
        }
      },
      switchPrevious(){
        this.current=this.previous.pop();
      },
      getUserId(){
        this.$http.get('/api/user').then(function(response){
          this.idUser=response.data.id_user;
          return response.data.id_user;
          
        },function(error){
          console.log(error);
        });
      },
      deleteTest(id){
        if (confirm('Вы действительно хотите удалить данный тест со всеми его вопросами?')){
          this.$http.delete('/api/test/'+id).then(function(response) {
            var self=this;       
            self.switchMainView('test-form',{title: 'add'});
            self.$refs.testSidebar.getTests();
            this.showPopupDelay(1200);
            this.popup.header="Тест успешно удален";
          }, function() {
              console.log('failed');
          });
        }
      },
    }
    
    
});



function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

