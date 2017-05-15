<template>
	<div class="container-lg">
		<div class="mb30"><h1><small>Изменить список опубликованных групп в тесте</small> "{{test.name}}"</h1></div>
		<div class="mb15">
			<select v-model="selectedGroupId" name="id_group" class="form-control publish__groups-select">
        <option v-for="group in groups" :value="group.id">{{group.group}}</option>
      </select>
      <button class="btn btn-primary" @click.prevent="selectGroup">ОК</button>
		</div>
		<div class="publish__groups mb25">
      <span class="publish__group" v-for="(group,index) in selectedGroups" @click="extractGroup(group,index)">{{group.group}}</span>
      
    </div>
    <div>
    	<button class="btn btn-success" @click.prevent="submitSelectedGroups">Изменить состав групп</button>
    </div>
	</div>
</template>
<script>
	export default({
		props: ['array'],
		data(){
			return {
				test: {},
				b: 0,
				selectedGroups: [],
				groups: [],
				selectedGroupId: null
			}
		},
		watch:{
			array(val){	
				this.getTest();
			}
		},
		created(){
			this.getTest();

		},
		methods:{
			reinit(){
				this.selectedGroups= [];
				this.groups= [];
				this.selectedGroupId= null;
				this.getGroups();
			},
			getTest(){
        this.$http.get('/api/test/'+this.array.testId).then(function(response) {
            this.test=response.data.test;
            this.reinit();					
            console.log(this.test);	
          }, function(response) {
              
          });
      },
			submitSelectedGroups(){
				let dataGroups=[];
        for (let key in this.selectedGroups){
          dataGroups.push({
            id_group: this.selectedGroups[key].id,
            id_test: this.array.testId
          })
        }
        this.$http.delete('/api/testgroups/'+this.array.testId).then(function(){
	          this.$http.post('/api/testgroups',dataGroups).then(function(){
	          	this.getTest();
		          
		        },function(response){
		        });
	        },function(response){

	        });
        
			},
			executeSelected(){
				for (let key in this.test.test_groups){
					for(let group in this.groups){
						if (this.test.test_groups[key].id_group==this.groups[group].id){
							this.groups[group].disabled=true;
							this.selectedGroups.push(this.groups[group]);
							this.groups.splice(group,1);
							if (this.groups[parseInt(group)]!==undefined){
							 	this.selectedGroupId=this.groups[parseInt(group)].id||null;
							}
							break;
						}
					}
				}
			},
			getGroups(){
	      this.$http.get('/api/group').then(function(response) {
	          this.b++;
	          this.groups=response.data;
	          this.selectedGroupId=this.groups[0].id||null;
	          this.executeSelected();
	        }, function(response) {
	            
	        });
	    },
	    selectGroup(){
	      for (let group in this.groups){
	        if (this.groups[group].id==this.selectedGroupId){
	          this.selectedGroups.push(this.groups[group]);
	          this.groups.splice(group,1);
	          if (this.groups[parseInt(group)]!==undefined){
	         	  this.selectedGroupId=this.groups[parseInt(group)].id||null;
	        	}
	          break;
	        }
	      }
	    },
	    extractGroup(group,index){
	      function sortById(a, b) {
	        if (a.id > b.id) return 1;
	        if (a.id < b.id) return -1;
	      }
	      this.groups.push(group);
	      this.groups.sort(sortById);
	      this.selectedGroups.splice(index,1);
	      if (this.groups[parseInt(index)]!==undefined){
				 	this.selectedGroupId=this.groups[0].id||null;
				}
	    }
	  }



	});
</script>