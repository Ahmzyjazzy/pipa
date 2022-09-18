## PIPA


### How to get code to local system

* Goto your wamp/www or xamp/htdocs and open a terminal or git bash. Run ```git clone https://github.com/pedestalsystems/pipa.git```

* Aftr the clone is successful, ```cd pipa`` on your teminal or manually open the project with your code editor

> NOTE: Alwaus work on *develop* branch only. Type ```git branch``` to confirm the branch you're working on.
> Type ```git checkout -b <branchname>``` to switch to a branch


### How to contribute or make changes to file

* Open file you want to work and make changes

* Open terminal in the root of the project and run ```git add .``` to stage all the files you want to add to commit

* When the above is successfull, you can type ```git status``` to confirm if there is any files left to stage

* Then when you're done making changes, run ```git commit -m "your commit message here"``` 

* When the above is successfull, you can type ```git status``` to confirm if there is any files left to comming

> NOTE: For short cut to stage and commit your changes at once use ```git add . && git commit -m "Your commit message here"```


### How to push your changes

* After you're done working, to push your changes online first run ```git pull origin <branch>```
branch represent the current branch you're working on that you want to push.
Type ```git branch``` to confirm the branch you're working on.

* When pulling is successful and there is no *merge* conflict then run ```git push origin <branchname>```
to push your changes to the online repository. This process will continue until you're ready to deploy 
to cpanel


### Deploying to CPANEL
