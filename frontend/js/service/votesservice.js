class VotesService {
	constructor(){	
	}
	
	findVotes(id){
		return $.get(AppConfig.backendServer+'/rest/votes/'+ id);
	}
	
	addVotes(id, votes){
		return $.ajax({
			url: AppConfig.backendServer+'/rest/votes/' + id,
			method: 'PUT',
			data: JSON.stringify(votes),
			contentType: 'application/json'
		});
	}
	
	findSurvey(id) {
		return $.get(AppConfig.backendServer + '/rest/survey/' + id);
	}
}