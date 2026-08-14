Liebe Frau Nestserava,

danke für die rasche Rückmeldung.

Anbei meine Antworten:

Zu #1 :

> > Ich weiß momentan nicht wie ich die Testcases beschreiben soll, bzw. wie ich die ganzen Testdaten bereitstelle.

>I think that you described the test cases in the KIMIPortal_Tests_DEV_20260607.pdf file that you provided. Does this file cover all the main test scenarios?

Answer:

These are just the key test cases for the batch processes.

There are a number of PHP scripts which, in principle, all do the same thing: they execute SQL queries, read CSV files and write CSV files – so, in my opinion, they are meaningful if they run. However, you mentioned in the status update that bug fixes are still required here.

My preference is to carry out the further tests in the KIMI test environment

Zu #2

>> Mir wäre es recht, das wie die Tests dann schon in der KIMI-Testumgebung machen.  
>> Bitte dazu um Ihre Meinung.
>
> I suppose that with the database dump with 2022 data you provided, I can go over the test scenarios locally first. And after the deploy to the test server, you'll be able to test the same steps from the file KIMIPortal_Tests_DEV_20260607.pdf file. Is that correct, or do you have some doubts that these scenarios in KIMIPortal_Tests_DEV_20260607.pdf are enough?

Answer: See answer #1

Zu #3

> > Es wäre super wenn wir diese Frage unabhängig von der Migration klären könnten, weil die Änderung ein große Arbeitserleichterung für die Agenten ist.  
> > Können Sie sich das zusätzlich ansehen?
>
> Do you want this task to be done together with the upgrade to PHP 8.5, or it should be done separately?  
> Am I understand right the task:
>
> 1. add 6 new columns to the oko table (telnr5–telnr10):
ALTER TABLE oko  
ADD COLUMN telnr5 VARCHAR(45),  
ADD COLUMN telnr6 VARCHAR(45),  
ADD COLUMN telnr7 VARCHAR(45),  
ADD COLUMN telnr8 VARCHAR(45),  
ADD COLUMN telnr9 VARCHAR(45),  
ADD COLUMN telnr10 VARCHAR(45);
>
> 2. update /kimi_ET/kimibatch/okoimp.php batch script to store the data in the new fileds telnr5–telnr10
>    
> 3. Add /modules/gui/templates/tickets/35/ticket.php table rows with table cell with a text input, a telefon icon image. Clicking on the icon triggers the outbound call
>    
>  
> Is that correct?
> 
The problem I see here is that to update the database with ALTER TABLE oko, it  should be executed on the production later.  
Am I understand right that usually to update the database, you run the SQL query right in the production database?

Answer:

Yes, separately: this involves implementing the ONClick functions in the existing PHP file. It would be helpful if we could do this as soon as possible.

The changes to ticket.php and okoimp.php have already been made. The ONCLICK functions (see HTML) aren’t working; I don’t know how or where to place this JS code ?!? or how it is generated. So the issue is with the ONCLICK functions.

And we don’t want to lose these changes during migration.

At the moment, database changes are being made directly in the production environment. We currently have no deployment process. Suggestions for improvement are very welcome. We also don’t use any development tools; we just edit the files manually. Here too, we’d appreciate any recommendations or suggestions on how to improve this.

Zu #4

Außerdem zur letzten Frage: Die PHP-Version ist 8.5. Für MariaDB kann die Version 12.3 LTS verwendet werden.

Answer: Danke