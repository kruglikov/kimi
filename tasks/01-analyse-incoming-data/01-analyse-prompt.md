We have next request from the client:  @docs/01-initial-request/initial-request.md
And here's what we responded: @docs/01-initial-request/initial-responce.md

The client sent us an archive with the incoming data-archive, which was extrcted to @docs/02-Kimi-portal-innowise-archive/KIMI-Portal folder.

# Documentation

In @docs/02-Kimi-portal-innowise-archive/KIMI-Portal/KIMIPortal_202604.pptx we have 26 slides with next information: 

01 - general database model infograhpics.
02-03 - login form
04 - DB Client(mandant) \ User(benutzer) relation \ user_role
05- welocome message
06 - campaign creation form + db structure
07 - Ticket Search (suche)
08-10 - Ticket details
11 - personal data encryption
12 - List boxes + db structure
13 - telephone calls + logs
14 - Ticket details field validation
15 - empty slide
16- Campaign files stored in /KIMI-Portal/web/htdocs/kimi_ET/modules/gui/templates/tickets/{campaign_id}
17-18 - batch import\export files & scripts are in
KIMI-Portal/web/htdocs/kimi_ET/kimibatch/files/{campaign_id?}/
19 - 95% copy\paste developemnt
20 initial/
21 - no longer active scripts(!) in /KIMI-Portal/web/htdocs/kimi_ET/modules/initial/
22-26 - batch processing scripts examples of output work logs

# Source code

I copied the project code sources from @docs/02-Kimi-portal-innowise-archive/KIMI-Portal/web/ to @src/original-src/web/
So, the original PHP files are stored in @src/web-original/ folder.
It's architecture is described in @ARCHITECTURE.md file.
(Folder structure is fully described in that file: @tasks/01-analyse-incoming-data/02-folder-structure.md if you need it)

Preliminary plan is stored in @tasks/01-analyse-incoming-data/03-preliminary-plan.md


1. See the preliminary report structure: @tasks/01-analyse-incoming-data/04-asessment-report-v01.md
- Please propose docker file and where I can position it so that locally I could launch the project 



