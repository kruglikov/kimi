Innowise x KIMI-Plus - May 26, 2026
https://app.bluedothq.com/preview/6a157cb3a53f7a0be0c40e31

---

0:00 - Darya Nestserava
Hello, friends. Can you hear me? Well, I think that I cannot hear you.

1:42 - Franz Tausch
Yes.

1:43 - Darya Nestserava
Oh yeah. Everything is okay. Oh no, again, I cannot hear you. Still do not hear you.

1:59 - Franz Tausch
So once more my question. Can you hear me?

2:02 - Darya Nestserava
Yes. Yes, yes, yes.

2:04 - Franz Tausch
Wonderful. Good afternoon.

2:08 - Darya Nestserava
Good afternoon.

2:09 - Franz Tausch
Good afternoon. Nice to meet you.

2:12 - Darya Nestserava
Nice to meet you.

2:13 - Franz Tausch
Thank you. Hello, Mr. Victor.

2:18 - Viktar Kruhlikau
Hi.

2:18 - Franz Tausch
Hi.

2:19 - Viktar Kruhlikau
Hello.

2:20 - Franz Tausch
Good afternoon.

2:21 - Darya Nestserava
So again, nice to meet you finally. I guess that I can briefly introduce myself again and my colleague, of course. So I work as a service delivery specialist and for now I'm ensuring that the service that we delivered for you is completely transparent and consistent and aligned with all the expectations. And also I work closely actually with Michael. So you just feel free to contact me as well, anytime. Yes. And here today is my colleague Victor. He's for now a responsible developer for your request. So yeah, I guess that's the main topic for today, the plan for testing, if I'm not mistaken. But before that we have a couple of questions.

3:20 - Franz Tausch
Yes, please.

3:21 - Darya Nestserava
Yes, if you would mind. Great. So the first one.

3:26 - Franz Tausch
Yes. Yeah, I would also introduce me.

3:31 - Darya Nestserava
Yes, Sorry, sir.

3:35 - Franz Tausch
Yes. My name is Franz Tosh. I'm the owner and the IT manager of Kimiplus and in my history I was a developer software developer for. Yes, since 1908 on hosts and so on. And the last year I only manage our system. And so I hope I can give you today the right. Right answers as complexity in Autolocain is for me a very important point. So I will ask you from my information you give up for the dialogue process. If you hear questions. Do you have questions? This is important for us. While this ought to look in is very, very important to the process from the call center agents and the flow of the many tasks I have to do to do to make. As a course with the debt owners. And now we wish us a very, very, very light and lovely solution. But I hear read in the emails this complexity and so I hope we make a step for about today.

5:29 - Darya Nestserava
Yes, thank you very much. Victor.

5:33 - Franz Tausch
Yeah. Your questions please.

5:35 - Darya Nestserava
Yes, okay. Maybe.

5:38 - Franz Tausch
Well, no, sorry, sorry. Oh, no. Yes, Only the point from auto lock in is very important for us today. The only sense. Every. Every Also. Yes.

5:57 - Viktar Kruhlikau
Well, I'm not sure who should start. Maybe Franz, you have some questions Furthermore, before our questions from my side probably questions more regarding the scope and how do you see the testing process and deployment process the general flow. I think you have some general.

6:22 - Franz Tausch
That's the next step. Yeah. Once to begin or one question your analysis are ready and you have. I've read you as the code Changes are made and the next step were test test from you from changes. Do you have make from the actual version from PHP and database version and server systems? Yes. Is this right? You are ready? Analysis is ready and the code is changed?

7:13 - Viktar Kruhlikau
Yes.

7:14 - Franz Tausch
Okay.

7:15 - Viktar Kruhlikau
And the code was updated during the analysis. I started to use AI tools and I created some safety tests. Not the whole testing, but to run quick tests that cover main functionality and most of just starting make sure that these bulk scripts are starting. And I updated the version and fixed some minor issues that appeared. I run the script that auto update the version and of PHP. So in general the code should work on PHP 8.5. Yes. But there are still some possibility that some corner cases maybe.

8:09 - Franz Tausch
Yes, yes.

8:10 - Viktar Kruhlikau
Something can be not covered by the tests.

8:13 - Franz Tausch
Yes. Okay. Yes, thank you. Thank you. Understand. Yes. Okay. Yeah. Then we discuss the test. Yes. Or our test environment. Yes, we have by our provider we have a test server. It's one to one to original to production. Yes. This database and system configuration and all complex. It's only test server and production server. It's one to one. This was idea. We start this version since 2022. Yes. Now it's. So now is. You have. We had. We had made many changes only in the production system. You know, it's a reality. And also the test database is not on the actual stand. So it's next to actual version. Yes. And so. Yes.

9:32 - Viktar Kruhlikau
Yeah, sorry, I may understand, right? Your idea. So you have two. Two system production system and the test system and the environment for test system you already upgraded right? To the.

9:47 - Franz Tausch
Yes, yes, yes. Database version and PHP version server version also server version. We must. We must upgrade to Debian 13 or 12 or 13 from our provider. It's. It's in August. We should do it. We should do it. Yes. And so the first steps in our idea was upgrade from the test server and install. Let install all versions you pro.

10:24 - Viktar Kruhlikau
You

10:28 - Franz Tausch
refer to us at BFA at 5 etc. And MySQL version etc. Then exia is that I did in Vienna and then would he install us a test a new test environment so completely. And. And then we all know we only have old source code. Yes, and. And. And. And then as any seed idea you give you become for band connection to you.

11:11 - Viktar Kruhlikau
Ah, VPN connection.

11:12 - Franz Tausch
Yes, it's one. One idea. One idea. One idea. You became a Fabian connection and then can you roll out. You can roll out Septuor's code. It is clearly you must. You must speak with Anexia and control all. Yes, but assist two Annexia works together to summon. To summon you and Annexia built the test system on the end. Yes. And Annexia is environment and you are. The changes in configuration you need from your analyze you make. Yes, this is the idea. One question is the version of the database. Our database is in production in small database but in the test it's very very small data on old data. And I think it's better we can work with actual data. And so the idea with for Ben that is better as we make a dump and delete data sets and data. I think it's make problems when you delete wrong configurations. When you read the deletes there's the wrong tables or data doesn't set records. So the thing I think it's more problem as we. You work on our startup as directly. So it's one. It's. Yes. Mm.

13:34 - Viktar Kruhlikau
So what I understood that the first idea that you have is that we will. We will connect with Annexure Annexia will prepare a new test environment and once Innovise have has VPN connection to this environment we will be able to set up some set up the system updated version of the code and it sounds quite okay. Regarding. But you also mentioned the database version. Yes. And usually when someone upgrade MySQL version to the latest. There are no problems with that data upgrade. Usually everything is processed. Okay, but you mentioned that you need to delete some sensitive data, right?

14:46 - Franz Tausch
Yes.

14:47 - Viktar Kruhlikau
And once we delete the sensitive data we can break something on the test environment. And on the test environment not everything work. Am I understand right?

15:00 - Franz Tausch
Yes. Yes. The first idea is on the bottom point our information very critically it's debt management. Yes. Our business is. Our business is to make debt calls. When you don't have paid your bill on Amazon or Klarna or whatever. Our Our clients become information and say handle C stepped. Yes. And we only call this step to the debit to them. And there's a sensible information of this fo. You know. And so I have not fun to give this sensible data to export. Why it's very very hard to change the sensible data. Yes it's. And I can now actually I can't. I can't say. Users. Often say resource I need yes to that in time and then. And so it's a first step step to make anxia. But is this menu when you say and this is important when you say this is better, this is better. You became a little debate. Yes. And you can work on your environment and finish go to finish any tasks and then it's okay Then would it be. Is also this okay for me? Yes, but I have no no idea. I'm. I'm alone. Yeah, it's and. And I must. Yeah. Yeah. I must find a way a short way. And, and, and yes to to. To build a database and we can dump to you. Yes, it's also okay. We only look at the time. We only look at the time of the completely project. Yes, it's important. I don't know now what is the timeline? Yes to the end. Yes. When we today ask discuss we will test stem. We must also discuss Anexia. They also need time and auto looking also need time and so we look to the timeline. But when you say this is the better way then it's okay for me. Then we. Yeah. Okay. Just send you. You, you can you can define the process is important for me. You are the. The specialist and I think it's. It was the best process, the slowest, the fastest process. Yes okay. But it's only an one step. When you say nine. No, when make other then it's okay. Yes, you can choice it.

19:06 - Viktar Kruhlikau
Well, am I understand right that you mentioned the one idea is that Anaxia and auto looking. Right that you mentioned some others. I heard that you mentioned some auto looking. I, I, I thought that maybe it's

19:34 - Franz Tausch
something It's a, it's a. Yes, it's a program. It's a problem.

19:41 - Viktar Kruhlikau
Yeah.

19:41 - Franz Tausch
The problems with auto looking. Yes, it's a second second. Second point. Second point. But but I think it's better we we separate these two two points. All in all, in our project I think it can upgrade very fast. It's nearly time. Yes. And in the second step we can find the best solution. I think in the process of the software who interact. Yes. Telephone software and Kimi Kimi plus it's a pape make changes also in the telephone software when it possible. Man. The solution this needs or this a solution that the tokens or auto look in are also needs changes in the telephone software from our telephone provider. We can do it. But this yeah. Needs time needs time to to. To. To. To. To speak over the changes and you know what I mean? Yes. So I think outlook in a second step first upgrade to actual behavior etc. Yeah, I think that's a good way. I hope you think also this is a good way and agree.

21:44 - Viktar Kruhlikau
Yes, agree. So if I understand correctly, the first step is to set up new environment new test environment. Just roll out the updated version of the yes. Of the system and just test it and make sure that after the upgrade. It works well on all scenarios.

22:09 - Franz Tausch
Yes.

22:10 - Viktar Kruhlikau
And only after that.

22:12 - Franz Tausch
Yes. Yes.

22:15 - Viktar Kruhlikau
Okay, then the yes question about autologing is the second question. The first one first question was about the database dump. Yes, I think that I can check and. Yes, so you don't want sensitive data exist on the test test environment, right. And are these sensitive data? Is it only contact data or we have some separate table with depth information or address information?

23:03 - Franz Tausch
They are not separated. They are not separated. They are only. I don't know in English. Yes. Telephone number, name, address. It's in the same table. But we crypt its information on database. Yes. And so I think it's the basis to give the to make database stamp. But it is also sensitive to. But we have your agreement. Yeah, we have your agreement for our work together. And so I think when minute I make it light. Yes. Then I only make a database stamp from the test environment. The production are too big as there are many, many, many data. The test is stand version version 2022. My orcas two wheel. This is the time movie setup this system bionics. Yeah. Yes, but I think when you. When you. When we. When we. When we test to needs the time from the test environment. Yes, the structure is. Is the same, but the content is 2022, you know, and I think we must. Can you introduce to test cases. Which functional on this. On this. On this version 22 database? Yeah, you know, can you give the right data to test? You can adjust so you will. Yes, but when. When. When data set. When. When not all records in the database or done then I think it was be able. Functions will not function. Yes, you know. What do you mean?

25:51 - Viktar Kruhlikau
Yes, if we take a current database structure and use 2022 data, everything should work fine.

26:03 - Franz Tausch
Yes. Yes, yes. Yes, it is possible. It is possible, but I don't know, you know, but it's a light way. And so I think when we dump the test database and we give you the dump, then this point is ready.

26:30 - Viktar Kruhlikau
Yes. Or another option I think can be that we can. If you are able to modify the dump of the production data and just remove sensitive data from it. I mean for example, if I I don't remember the actual database structure currently, but if we have a table with the use users who has depth.

27:00 - Franz Tausch
Yes.

27:01 - Viktar Kruhlikau
And. And just keep the structure and remove this the whole content of this data, will it be okay or it breaks everything.

27:13 - Franz Tausch
Yes. One question in my is, you have seen it on the code. Yes, it's copy and paste. And when we become a new client, then we copy and Paste and then we make the last changes on the flow. 95% is the same code and the rest 5% are individual. Yes. And in code also in database. It's the same idea. It's the same model, but it's copient based. And So I have 20 fields here and one client number five. I had 22 fields. Yes. You know, this is different. But. But I have a. The idea. Yes, you have here change the code and the code is copied. And so think I. It's. It's on not with problem is the code. It's only can the database or the agent or the mantanto or the tickets survey could be processed. Yes. And so I can describe what you can test one. One client. One client over all the processes. Yes. We have 10 clients. Five clients. Five. Yes, we are a little company. Yes. And so can. So I can make the data of a not so important client. You know, if you have clients sensitive. Yes. With this and, and. And. And data security. Yes. And we have clients with is. It's all okay, as you know. And, but. And. In sekoa. In sekoa all source code is for. Source code for yeti for every client. Yes. And so. Can you give you a data set from one client, A little client not so important client. And so we have not so many risks with data. And you know, and the other tests. And that's the other test. The other test when we must make test quality. Yeah, when the quality tests roll out and go live. Yes. Then make it be on. On. On the. On the production database says two steps. I need at first make a dump from the actually test database standing version 2022. I. Yeah, it's run and was a internal function test for me or the our agents over all clients. I would test with my colleagues on test system live in Kimi desk test system. And so we have two phases. You have the basis tests functionally so. Okay. And. And then I think it's not many problems. Yes, you understand me?

31:20 - Viktar Kruhlikau
Okay, I'll repeat how I understood your ideas.

31:23 - Franz Tausch
Yeah, yeah, yeah.

31:24 - Viktar Kruhlikau
So we have test environment. And on that test environment we. We apply database dump with current structure but with data from 2022. And you will provide some one or five clients with more or less realistic data so that we could click and check this that process some scenarios are working.

31:53 - Franz Tausch
Yeah.

31:53 - Viktar Kruhlikau
If once we test and we fix this any bugs that we found and when you review everything is okay after the second phase.

32:06 - Franz Tausch
Yes, but this is not the same structure. When we get the. When we. When we install a new Client. Yes, you have seen it on the name of the tables? Yes, it's copy and paste and client Ions KMP Inco as this is name clients. Yes, I copy and paste the structures, the tables. The fields are the same, but I speak two fields more or less. Yes, this is. But the base structure is the same. Ticket is ticket. This is important. We have here many source files, but also copy and paste and batch processing as example. It's test by me. I know about functionality and it's one minute I see a function or no, you know, I only won't say the same. The structure is not the same as production. While when we install a new client, we don't make it. Since last year Sysgliant is not on the test database. It's why, why, why? You know, we go live with the data set and we start on production. It's not. It's not so. So not so lovely, but we make it so it's. It's a short way and yeah, it's easy. But since the base structure is onset, this database is right. And. Okay. And so. And so I. So I think we can test the other way.

34:24 - Viktar Kruhlikau
I'm.

34:29 - Franz Tausch
I have to do copy the production and delete all information of important sensitive clients. Yes, and it's. Yes, it's. It's. It's a way. It's a way. But the fastest way where to dump the test database and say actually version. I wish we tried when it not functioned. When it not functioned. Yes, many problems to you. Then make the great dump. Yes, but you know, it's. It's. Yeah, yeah.

35:20 - Viktar Kruhlikau
So we first try the first way when you take that data from 2022 and if it's too many differ.

35:30 - Franz Tausch
Yes, yes, you say that, you say okay or not okay. And when you say it's not okay, too many troubles. Then I must take the second task to dump the production database. Okay. And the rest it's the same. You need test cases or a question from me to you. What shall you test? Yes, I can give you information, but you can give me information we on which way you need this information. What you test. And I describe this test. Yes,

36:27 - Viktar Kruhlikau
yes, that was one of my questions regarding the functionality testing what scenarios we have. And also. Also the question related to this, this one is that on this new test system. You mentioned that you have elsebed system. It's probably some kind of desktop application and also some kind of integration with call manager. If that should be tested on the test environment or it's not related.

37:10 - Franz Tausch
No, no, no. It's Too complexity, too complex. We only can test HTTP to auto login. Yes, from this point, but only of the application. This must be test by Kimi. Yeah, we don't have test systems from this applications. Yes, but we test it life this the right Kimi version. But we have count test systems from our telephone software and so I don't. I can't test changes on two test versions. Yes, I must. Yes. This is where I think it's better we install this and back in me and send it. We should test it also. Yeah. Okay.

38:21 - Viktar Kruhlikau
Okay.

38:26 - Franz Tausch
Yeah.

38:27 - Viktar Kruhlikau
So if I understand correctly the current point we have more or less three parts of the the test task is to finish the rollout of the test environment then apply the dump 2022 and test and if it's it doesn't work in that case applied the production dump and you will sift out the sensitive data and then test. So that is in general, as I understand and I expect that you would like to have some estimate of efforts for this from our side on the final stage, right?

39:28 - Franz Tausch
Yes.

39:29 - Viktar Kruhlikau
So.

39:30 - Franz Tausch
Yes.

39:31 - Viktar Kruhlikau
To understand how much time it will take.

39:35 - Franz Tausch
No,

39:39 - Viktar Kruhlikau
and so I I just wanted to clarify to. To understand the amount of efforts of how much time it will take. It's okay. The. The environment creation. Should we be involved closely into the test environment creation with yes. Or. Or they they know what to do or.

40:06 - Franz Tausch
No. There was an axe providers to the server and the version of an operating system and database version. This. This task make an AXIA but functionality. Yes. And processes between software. Yes. It's no team for Nexia. So I think we must communicate. You must communicate with Ania with admin and all together.

40:48 - Viktar Kruhlikau
But

40:50 - Franz Tausch
it's important that you help us to define the right doings to Annexia. Yes. Inversion and in tasks. So we work together in this point. And so you need time for. Yes. Meeting or. Yeah, as well. Yeah.

41:25 - Viktar Kruhlikau
Okay. Yeah. So they provide operating system PHP database. Have you already requested this from them?

41:41 - Franz Tausch
The communication process tests. The result of tests is functionally is okay. And why do you know the functionality is okay? We make the final check on results. You know, I don't know. I have a picture. You test the system technology and you make your test cases. I think it's modern modern system you make it and so. And so you go. You can work widely in the process. But at the end when drop is yes. When problem or end finally check from results. Check checks. Check the saved call. Yes. The information show at the output output report to the customer. We will send at the evening. Yes, I can Say okay you your tests are okay because on the evening your call is in the export file and all data are okay. This is this test. Yes. You know, you make this functionality in small or great program pieces. Yes. Or test cases yet. But finally test is sets a call and the result of the call and all information what giving from the depth owner to our agent is in the system and I can send it on the evening to our client. Yes, this is finally tested and and this that make must make. Yeah yeah. As a test for me it's complex. You, you. You. You know my question. What do you test and what you test and and and and why we commonly communicate when rubbers or problems and or check check finally check. Given this result. You said test is ready. Here's the result and the process overall. Yes it's my test send in when we install it in Kimi. Yeah but in the first step you test and do your results. You make technical results, but the logical results or problems this I don't know why we can't be we. What is the communication way between us during the test faster. You know, make use this test also alone or need you. Yes me in the test or one contact you me. You know my question.

45:11 - Viktar Kruhlikau
So yeah as I understood in my understanding how that would be is that you mentioned that you will you are able to describe what should be tested. Provide some test users and describe. Okay, here is that the how it should work so that once this the after the environment is ready we test first it these scenarios and maybe we have some our ideas what to test. Click some obvious things and see and after that if everything is okay then you you can look and check.

45:57 - Franz Tausch
Yes. I think it's it's important that we ask about the structure of test information. Yes.

46:08 - Viktar Kruhlikau
I

46:11 - Franz Tausch
It's the first time I make test cases. Yes. This is the first time I make test cases on paper or or structured test test systems. Yes. You know my I I don't know how many time I must invest that to make test cases. How many test cases you know. And so I come back to our process as a little company. Okay. Change the code and one minute I test it you know, when I make it test cases and describe the test cases that you the can test cases put in a test system automatically. Yeah, I think it's so yeah. Then yeah. What is the format? What is your build your your your your picture from a test case. What must I describe? I was a test. You know. You know my question this is I I I I I know this test is not the test so. But needs many resources on describes test cases, test data. Yeah, and. I find a way for me. But I don't know of obsessed information and asked to you for many for me tests I don't. Yes, it's the first time when you say we become test cases. Yes, but we must describe in the first step, what do you need to test? I can write a test case. So I think you can work I don't know. And you may know how many test cases we need. Yes, and so we. So the first step you can test your system with the thumb test desktop wide and finally technical. Yes. And I give you the right information for the test dump which client, which user Also which ticket. Yes, tickets and but how many test cases you do you need? Yes, this question is. And so must try it. Yes, but finally test is important test. I think.

49:24 - Viktar Kruhlikau
Yeah. Regarding the question, how many tests do we need? It's hard to say. I think that first we should cover main success scenarios. So at least one one test for one success scenario. When you for example, you come from this.

49:50 - Franz Tausch
If you have your layouts for this description, do you work for me or must write it by myself? You know.

50:07 - Viktar Kruhlikau
You mean you need to understand in what form this.

50:11 - Franz Tausch
Yes, you know the description. What form I give you the test information that you can work and. And. And can fast. Good Test. Is it a word description? This is a xls file.

50:27 - Viktar Kruhlikau
I think this. I can write it in a follow up email for this meeting. But in general it can be in a free form. We can use just a text with for example links. You can open production even production environment and copy link. But it will not lead to real data. But later on the test server we will be able to update these links for example or steps and then click this button and after that click this button and something like that, I suppose. Yeah. We can align this in. In email, I think.

51:13 - Franz Tausch
Yes. Yes. Okay. Yes okay. Yes, I will try it to to description a test on. On my picture and. And so I hope you can give me a feedback what do you need to work when it not okay. Yes, so I can see what I must do and how many time I spent them to test. Yes. Now we have no tests. We change and click and. Yes yes.

51:51 - Viktar Kruhlikau
In general, I think that this test can be just written text. What can we manually.

51:59 - Franz Tausch
Okay. Action and result. It's no. Yes yes, yes. Okay okay. Yes, I understand. Yes, it's important for me where I must write something test. Okay, okay.

52:11 - Viktar Kruhlikau
Okay. So am I understand right that now we are discussing only the Testing process. So we don't even discuss the this auto login bypass problem delayed for later. Right.

52:26 - Franz Tausch
Yeah.

52:26 - Viktar Kruhlikau
Okay. So I think that what we can do for now I can write a follow up after this meeting how I understood what we were discussing this setup task, our testing task, final testing.

52:43 - Franz Tausch
Yes.

52:44 - Viktar Kruhlikau
And I'm not sure that I understood everything 100 correctly. So I'll write additional questions. Yes.

52:53 - Franz Tausch
Thank you. Thank you very much. Yes.

52:56 - Viktar Kruhlikau
And you will comment and ask.

52:58 - Franz Tausch
Yes. Yes. Yes.

52:59 - Viktar Kruhlikau
So we will formulate this with this.

53:01 - Franz Tausch
Yes. Thank you. Yeah. Yes, it's a good way. Yes. But only one question. Does auto look in I don't know the functionality which one way tokens. Yes. Now it's. So when. When we about our.

53:29 - Viktar Kruhlikau
May I interrupt you I have idea how we can solve this for this problem.

53:33 - Franz Tausch
Okay. Yes. This is a question Y.

53:36 - Viktar Kruhlikau
The main problem is that it's auto logins users just by URL so you don't have to enter even password to log in as a user. And the easiest way to solve that and the most secure way is to I follow the link if I'm not logged in as the user in the URL at first I need to enter the password and after that the system redirects me to the link I entered initially. So if it's work for you that in that case.

54:14 - Franz Tausch
Yes, yes. Yes. This is an important question I don't can't answer alone. This is a point is discussed with my partner Mitsu Sana. Explain when we make power tiling. Rules. Yes. Then we send it to the power dialer in batch administration and send a power dialer and then other process began to call the debt owners and she calls 1, 2, 3, 4, 5 and when one depth should go to the telephone and said hello then in this moment. In this moment the power dialing software looks where agent is free on a logic. Logic. Yes. And then the free. Free agent becomes a call pop up. Yes. Information to the client version. It's. It's. The agent has started the client version and in the background runs the power dialer and our agents. Our agents some multitasking agent we have. We have outbound sessions where. Yeah. With small. Small calls or less calls. Less call. Yes, thousand calls. 10, 10, 10 results. Yes. You know, it's a background and so he works on the second service. Second system. Yes. And then one telephone Chemi telephone and power dialing and so which call comes in. Okay, then that's. It's. It's a. It's okay so but now when I must log in when Pop up. Yes, you know now now it. You must understand when. When the call come in the debt owner is on the telephone four or five seconds. Ten seconds. And when now master agent. And now the agent pop up by agent. He sees the applications, he sees the names, he sees all information and he can communicate and greet debt owner in the same moment. And now he must. Yeah, the agent is on the 5 seconds on telephone as the depth owner is 5 seconds on telephone and now must as a. As a agent ah call ah login, you know. Yes, he know. He don't know what on what what what is on the end on other end of the telephone is. And yet. And every second is important my colleague Susanna is very every second but after seven seconds the depth owner. Oh oh. I put the telephone down. Yes, I don't explain you that it's every second is very important and I understand the solution but the best way.

58:14 - Viktar Kruhlikau
Yeah.

58:15 - Franz Tausch
Is another way with tokens. I think a solution with tokens we give to the systems who called us maybe tokens who only works one day or 10, 10 hours or five hours. Can the question is can we give tokens? Can we give tokens? It's important. Can we give tokens. But you. You need a token to the user. Okay, I understand to the user. Yes, but when we have token and we can give tokens to our to Elspet or to Telematica and then send, generate, generate and say URL. Yes, with auto lock in today, Today we change Elspet the user Elspeth to the user to the owner. But the token. But we have the possibility to give a password in the URL. Yes, we change it and add a password in the URL with a token. Then we can give them another way. I only need a token who one day is okay. Or so and you know, but then it's automatically. Yeah, I think important is. I understand. Automatically login without password without stock and no go. I understand but user dynamic user is dynamic token time.

1:00:28 - Viktar Kruhlikau
Okay, I understood your point that these URLs the time is important and the URLs are important and you think that some approach with the tokens can work here and. Okay. May I also write you a follow up questions in the email regarding this auto logging problem because I have a hard stop and I need to go to the next meeting so I can. I think that we can follow up in the email.

1:01:05 - Franz Tausch
Yes. Okay, thank you. Thank you perfectly. Yes.

1:01:10 - Viktar Kruhlikau
Yeah, thank you.

1:01:11 - Darya Nestserava
Yes. I guess Victor, if you need to go, I can just sum up for France and you can go. Thank you very much for your participation.

1:01:21 - Viktar Kruhlikau
Yeah, thanks.

1:01:22 - Franz Tausch
Yeah, thank you. Thank you. Goodbye.

1:01:26 - Darya Nestserava
Yeah, friends, thank you very much for this super productive call. I guess. And your English is super.

1:01:36 - Franz Tausch
Yes, thank you.

1:01:37 - Darya Nestserava
I think it's a brilliant, brilliant. It's better than my German, trust me.

1:01:44 - Franz Tausch
Oh, yes. You know, it's. It's only. It's not so. So easy to speak language well when you don't speak such a language often. Yes. And so I work in. I work in it since many years and I must read something in English. But menu languages is not your hobbyist. And then it's not so easy to speak. But thank you for your comment. It's very friendly and yes, thank you.

1:02:36 - Darya Nestserava
I think you're doing just great. So. Yeah, I hope and I promise you that in. In the future I will try to speak my German because for now it's ein Bischen.

1:02:53 - Franz Tausch
Yeah. Yes. We can learn together.

1:02:56 - Darya Nestserava
Yeah.

1:02:57 - Franz Tausch
One time. So. One time. So we can. We can try talking. We can try also in English when you. When you say my English and so can I learn better English and. And when you have fun to learn German, we can change the city languages.

1:03:17 - Darya Nestserava
Oh yeah.

1:03:19 - Franz Tausch
Every time. Yeah. Yeah, that's right. Compliment. Yeah.

1:03:32 - Darya Nestserava
Nevertheless, I will write you all in Germany because for me it's super easy and I. I know all the grammar, so I guess that everything will be great. And yeah, we will discuss internally with Victor, sum up all the points and add additional questions for you.

1:03:53 - Franz Tausch
Yes.

1:03:53 - Darya Nestserava
And it will be. It will be clear and easy.

1:03:58 - Franz Tausch
Yeah, thank you very much.

1:04:01 - Darya Nestserava
Yeah, sorry for. For this time consuming call because we are talking an hour, no?

1:04:07 - Franz Tausch
Yes, but it was important the first call and this was important to understand us and thank you very much. I hope you have no problems with other meetings.

1:04:20 - Darya Nestserava
Anything for you, anytime. Just for you. If there will be a need, just also write me as well. And we will organize another call and we will.

1:04:31 - Franz Tausch
Yes, thank you very much. Yes, wonderful.

1:04:33 - Darya Nestserava
Yeah, thank you. Wish you a great day. Cheers.

1:04:38 - Franz Tausch
May a great day. Goodbye. 