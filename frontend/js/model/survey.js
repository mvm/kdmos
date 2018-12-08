class SurveyModel extends Fronty.Model {
    constructor(id, title, description, creator_id, options) {
	super('SurveyModel');

	if(id)
	    this.id = id;
	if(title)
	    this.title = title;
	if(description)
	    this.description = description;
	if(creator_id)
	    this.creator_id = creator_id;
	if(options)
	    this.options = options
	else
	    this.options = new Array();
    }

    setId(id) {
	this.set((self) => {
	    self.id = id;
	});
    }
    
    setTitle(title) {
	this.set((self) => {
	    self.title = title;
	});
    }

    setDescription(description) {
	this.set((self) => {
	    self.description = description;
	});
    }

    setCreator(creator_id) {
	this.set((self) => {
	    self.creator_id = creator_id;
	});
    }

    setOptions(options) {
	this.set((self) => {
	    self.options = options;
	});
    }

    newOption(id) {
	this.set((self) => {
	    self.options.push(new OptionModel(id));
	});
    }

    deleteOption(id) {
	this.set((self) => {
	    self.options = self.options.filter(o => o.id != id);
	});
    }

}
