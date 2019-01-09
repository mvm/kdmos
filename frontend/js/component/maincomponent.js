class MainComponent extends Fronty.RouterComponent {
    constructor() {
	super('frontyapp', Handlebars.templates.main, 'maincontent');

	// models instantiation
	// we can instantiate models at any place
	var userModel = new UserModel();
	this.userModel = userModel;
	var postsModel = new PostsModel();
	var surveysCreatedModel = new SurveysModel();
	var surveysPartModel = new SurveysModel();
	var votesModel = new VotesModel();
	this.userService = new UserService();
	
	super.setRouterConfig({
	    posts: {
		component: new PostsComponent(postsModel, userModel, this),
		title: 'Posts'
	    },
	    'view-post': {
		component: new PostViewComponent(postsModel, userModel, this),
		title: 'Post'
	    },
	    'edit-post': {
		component: new PostEditComponent(postsModel, userModel, this),
		title: 'Edit Post'
	    },
	    'add-survey': {
		component: new SurveyAddComponent(userModel, this),
		title: 'Add Survey'
	    },
	    'edit-survey': {
		component: new SurveyEditComponent(userModel, this),
		title: 'Edit Survey'
	    },
	    'created-surveys': {
		component: new SurveyCreatedComponent(surveysCreatedModel, userModel, this, true),
		title: 'Created Surveys'
	    },
	    'participated-surveys': {
		component: new SurveyCreatedComponent(surveysPartModel, userModel, this, false),
		title: 'Participated Surveys'
	    },
		'votes': {
		component: new VotesComponent(votesModel, userModel, this, true),
		title: 'Votation'
	    },
		'add-votes': {
		component: new VotesAddComponent(votesModel, userModel, this),
		title: 'Select your votes'
	    },
	    login: {
		component: new LoginComponent(this.userModel, this),
		title: 'Login'
	    },
	    defaultRoute: 'login'
	});
	
	Handlebars.registerHelper('currentPage', () => {
            return super.getCurrentPage();
	});

	var userService = new UserService();
	this.addChildComponent(this._createUserBarComponent(userModel, userService));
	this.addChildComponent(this._createLanguageComponent());

    }

    _createUserBarComponent(userModel, userService) {
	var userbar = new Fronty.ModelComponent(Handlebars.templates.user, userModel, 'userbar');

	userbar.addEventListener('click', '#logoutbutton', () => {
	    userModel.logout();
	    userService.logout();
	});

	userbar.addEventListener('click', '#loginSubmit', (event) => {
	    this.userService.login($("#loginEmail").val(), $("#loginPass").val())
		.then((user) => {
		    userModel.setLoggeduser(user);
		    this.goToPage("login");
		})
		.catch((error) => {
		    userModel.set((model) => {
			model.loginError = error.responseText;
		    });
		    userModel.logout();
		    this.goToPage("login");
		});
	});

	this.addEventListener('click', '#registerlink', () => {
      this.userModel.set(() => {
        this.userModel.registerMode = true;
      });
    });
	
	return userbar;
    }

	start() {
		// do relogin
		var userService = new UserService();
		userService.loginWithSessionData()
	    .then((logged) => {
			//alert(JSON.stringify(logged));
			if (logged != null) {
				this.userModel.setLoggeduser(logged);
			}
			super.start();
	    });

	}
    _createLanguageComponent() {
	var languageComponent = new Fronty.ModelComponent(Handlebars.templates.language, this.routerModel, 'languagecontrol');
	// language change links
	languageComponent.addEventListener('click', '#englishlink', () => {
	    I18n.changeLanguage('default');
	    document.location.reload();
	});

	languageComponent.addEventListener('click', '#spanishlink', () => {
	    I18n.changeLanguage('es');
	    document.location.reload();
	});

	return languageComponent;
    }
}
