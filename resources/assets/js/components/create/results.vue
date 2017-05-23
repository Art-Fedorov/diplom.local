<template>
	<div class="archive">
		<div class="container" v-if="Object.keys(this.modResults).length">
			<div class="row">
				<div class="col-md-12">
					<div class="archive__filter">
						<div class="archive__filter-item">
							<label class="col-sm-3 form-group__label">Фильтр: </label>
							<select class="form-control" name="" id="" v-model="searchIndex">
								<option value="0">Название теста</option>
								<option value="1">Название группы</option>
								<option value="2">Имя студента</option>
							</select>
						</div>
						<div class="archive__filter-item">
							<label class="col-sm-3 form-group__label" for="">Поиск: </label>
							<input class="col-sm-5 form-control" type="text" v-model="searchString">
							<button class="col-sm-4 btn btn-primary" @click="onSearch(searchString)">Искать</button>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 archive__test"  v-show="test.active&&countGroups(test)>0" v-for="test in modResults">
					<div class="archive__test-header-container">
						<h2 class="archive__test-header">{{test.test.name}}</h2>
					</div>
					<div class="row row-flexed">
						<div class="col-md-4" v-show="group.active&&countResults(group)>0" v-for="group in test.groups">
							<div class="archive__group">
								<h3 class="archive__group-header">{{group.group.group}}</h3>
								<div class="archive__result" v-show="result.active" v-for="result in group.results">
									<span class="archive__username">{{result.user.name}}:</span> <span class="archive__mark">{{result.mark}}<small>б</small></span>, <span class="archive__percent">{{result.percent}}%</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		<div class="container" v-else>
			<div class="row">
				<div class="col-md-12">
					<h2 class="">Результатов для опубликованных вами тестов не найдено</h2>
				</div>
			</div>
			
		</div>
		<div class="hidden">
			{{b}}
		</div>
	</div>

</template>
<script>
	export default({
		props:['res'],
		data(){
			return{
				results: JSON.parse(this.res),
				modResults: {},
				searchIndex: 0,
				searchString: null,
				b: 0,
			}
		},
		created(){
			this.modifyResults();

		},
		watch:{
			// searchString(val){
			// 	this.onSearch(val);
			// }
		},
		computed:{
		},
		methods: {
			modifyResults(){
				for (let key in this.results){
					this.results[key].active=true;
					let idT=this.results[key].id_test;
					if (this.modResults[idT]==undefined){				
						this.modResults[idT]={
							test: this.results[key].test,
							active: true,
							groups: {}
						};
					}
					let idG=this.results[key].user.id_group;
					if (this.modResults[idT].groups[idG]==undefined){
						this.modResults[idT].groups[idG]={
							group: this.results[key].user.groups,
							active: true,
							results: []
						};

					}
					this.modResults[idT].groups[idG].results.push(this.results[key]);
				}
			},
			onSearch(str){
				let self=this;
				self.b++;
				switch(parseInt(self.searchIndex)){
					case 0: 
						self.searchTest(str); 
						break;
					case 1: 
						self.searchGroup(str); 
						break;
					case 2: 
						self.searchUser(str); 
						break;
				}
			},
			searchTest(str){
				let self=this;
				let re = new RegExp(str, 'i');
				for (let key in self.modResults){
					let test=self.modResults[key].test;
					if (test.name.search(re)<0){
						self.modResults[key].active=false;
					} else {
						self.modResults[key].active=true;
					}
				}
			},
			searchGroup(str){
				let self=this;
				let re = new RegExp(str, 'i');
				for (let key in self.modResults){
					for (let ke in self.modResults[key].groups){
						let group=self.modResults[key].groups[ke];
						if (group.group.group.search(re)<0){
							self.modResults[key].groups[ke].active=false;
						} else {
							self.modResults[key].groups[ke].active=true;
						}
					}
				}
			},
			searchUser(str){
				let self=this;
				let re = new RegExp(str, 'i');
				for (let key in self.modResults){
					for (let ke in self.modResults[key].groups){
						for(let k in self.modResults[key].groups[ke].results){
							let result = self.modResults[key].groups[ke].results[k];
							if (result.user.name.search(re)<0){
								result.active=false;
							} else {
								result.active=true;
							}
						}
					}
				}
			},
			countResults(group){
				let count=0;
				for (let k in group.results){
					if (group.results[k].active){
						count++;
					}
				}
				return count;
			},
			countGroups(test){
				let count=0;
				for (let k in test.groups){
					if (test.groups[k].active){
						count++;
					}
				}
				return count;
			}
		}
	});
</script>