

var mixin={
  methods:{
    getUserId(){
      this.$http.get('/api/user').then(function(response){
        this.idUser=response.data.id_user;
        return response.data.id_user;
        //console.log(this.id_user);
      },function(error){
        console.log(error);
      });
    }
  }
};

var passSidebar=  require('./components/passing/pass_sidebar.vue');
var passSelect=  require('./components/passing/pass_select.vue');
var passQuestion=  require('./components/passing/pass_question.vue');
var passId1=  require('./components/passing/pass_id1.vue');
var passId2=  require('./components/passing/pass_id2.vue');
var resultId1=  require('./components/passing/result_id1.vue');
var resultId2=  require('./components/passing/result_id2.vue');

var testInstance = new Vue({
    mixins: [mixin],
    el: '#app',
    data: {
      tests: {},
      currentMainView: 'pass-select',
      showed: true,
      showSidebar: true,
      array: {},
      idUser: null,
      user: null,
    },
    components: {
      'pass-sidebar': passSidebar,
      'pass-select': passSelect,
      'pass-question': passQuestion,
      'pass-id1': passId1,
      'pass-id2': passId2,
      'result-id1': resultId1,
      'result-id2': resultId2
    },
    watch: {
      currentMainView: function(val){
        if (val=='pass-select') this.showSidebar=true; 
        else this.showSidebar=false;
      }
    },
    methods: {
      switchMainView: function(view,ar = {}){
        this.currentMainView=view;
        if (Object.keys(ar).length>0){
          this.array= ar;
        }
      },
      getUserId(){
        this.$http.get('/api/user').then(function(response){
          this.idUser=response.data.id_user;
          this.user=response.data.user;
          return response.data.id_user;
          
        },function(error){
          console.log(error);
        });
      }
    },
    
    created: function(){
      this.getUserId();
      if (this.currentMainView=='pass-select') this.showSidebar=true; 
      else this.showSidebar=false;

    }
});