# Email: RE: Follow-up on the Innowise x KIMI-Plus Meeting (26.05.2026)

**Forwarded by:** Darya Nestserava <darya.nestserava@innowise.com>
**Forwarded date:** Mon, Jun 15, 2026 at 08:18 UTC
**Original from:** Franz Tausch <franz.tausch@kimi-plus.at>
**Original date:** Mon, Jun 15, 2026 at 4:52 AM
**To:** Darya Nestserava <darya.nestserava@innowise.com>
**Cc:** Michael Bortnik <michael.bortnik@innowise.com>, Lizaveta Akulenka <lizaveta.akulenka@innowise.com>
**Subject:** RE: Follow-up on the Innowise x KIMI-Plus Meeting (26.05.2026)

---

## Attachments

- `attachments/image001.png` — inline screenshot (target path for CSV)
- `attachments/image002.png` — inline screenshot
- `attachments/image003.png` — inline screenshot
- `attachments/INKO2016.CSV` — batch test data file
- `attachments/ticket.php` — PHP source file

---

## Franz Tausch's Email (translated)

Good morning Ms. Nestserava,

thank you for the update.

Regarding the questions / notes:

#1 A question about the test cases: For the last scenario "Batch – Overview /kimidev_ET/kimibatch/kimibatchtree.php" – do we need a separate CSV file for that, or is it not necessary?

Test data INKO2016.CSV is enclosed.

Target path:

[image001.png — screenshot of target path]

#2 Will Anexia take over the current production server settings including the project folder, or will we get an empty server and have to set everything up from scratch?

The server will not be empty – we should define exactly what we need and Anexia will install the versions. After that we only need to verify and configure the necessary settings.

That is the plan. It would therefore be good to know exactly which versions we need to install.

#3 There is a red-marked bugfixing task. We do not expect major problems, but we would like to point out that some risk remains – especially in batch processing, additional effort could arise.

Thank you for the note. That is fine.

I currently don't know how to describe the test cases, or how to provide all the test data.

I would prefer to run the tests directly in the KIMI test environment.

Please let me know your opinion on this.

I also have one more piece of information / question / request / small extension:

How do we handle interim changes?

Specifically regarding OKO:

We need an extension of the phone fields in the form, so that phone numbers 4 through 10 can also be dialled easily and quickly.

There should be a phone icon next to each field Telephone 4 through 10.

Example (new):

```html
            </td>

            <td bgcolor=#FFFF00><?php echo "Telefon 4" ?></td>

            <td>

                <input style="width: 170px" placeholder="<?php echo "Telefon 4" ?>" name="dummy_text6" class="column" type="text" value="<?php echo $ticket->get_dummy_text6() ?>" />

                                                               <img style="vertical-align: middle;" src="../images/telephone.png" id="callTelco4" name="callTelco4" onClick="callTelco3()" width="16" height="16" alt="dummy_text6" />

            </td>
```

The question is about onClick="callTelco3()" and how to implement this correctly.

As it appears, a separate click function needs to be created for each phone icon.

In the HTML code it looks like this.

The question is where and how these are generated, and what changes are necessary.

It would be great if we could clarify this question independently of the migration, because the change would be a significant improvement for the agents.

Could you take a look at this as an additional item?

```javascript
      $("#callTelco3").click(function(e) {

            $this = $(this);

            e.preventDefault();

            $("#btnStart").click();

            $('#telefon_status').val('senden...');

            kampagne_iptel_destclid = document.getElementsByName("kampagne_iptel_destclid")[0].value;

            kampagne_iptel_auto_vorwahl = document.getElementsByName("kampagne_iptel_auto_vorwahl")[0].value;

            benutzer_iptel_durchwahl = document.getElementsByName("benutzer_iptel_durchwahl")[0].value;

            telNr = document.getElementsByName(e.target.alt)[0].value;

            clientIp = document.getElementsByName("client_ip")[0].value;

            nebenstelle = document.getElementsByName("nebenstelle")[0].value;

            $.ajax({

                url: "./index.php?site=callInntelco&ajax=true",

                type: "POST",

                data: {

                    'objekt': 'callTelNo',
                    'user': 'tauschfranz',
                    'iptel_durchwahl': benutzer_iptel_durchwahl,
                    'kampagne_iptel_destclid': kampagne_iptel_destclid,
                    'kampagne_iptel_auto_vorwahl': kampagne_iptel_auto_vorwahl,
                    'dest': telNr,
                    'client_ip': clientIp,
                    'nebenstelle': nebenstelle

                },

                success: function(data) {

                    var data = $.parseJSON(data);

                    if (data.retcode != "0") {
                        alert(data.msg);
                        $('#telefon_status').val('Fehler');
                    } else {
                        $('#telefon_status').val('Fertig');
                    }

                },

                error: function(error) {
                    alert(error);
                    $('#telefon_status').val('Fehler');
                }

            });

        });
```

DB change:

```sql
ALTER TABLE oko
ADD COLUMN telnr5 VARCHAR(45),
ADD COLUMN telnr6 VARCHAR(45),
ADD COLUMN telnr7 VARCHAR(45),
ADD COLUMN telnr8 VARCHAR(45),
ADD COLUMN telnr9 VARCHAR(45),
ADD COLUMN telnr10 VARCHAR(45);
```

I look forward to your reply.

Have a nice day,

Kind regards

Franz Tausch

---

## Previous message in thread: Darya → Franz (Jun 10, 2026)

From: Darya Nestserava <darya.nestserava@innowise.com>
Sent: Wednesday, 10 June 2026 17:53
To: Franz Tausch <franz.tausch@kimi-plus.at>
Cc: Michael Bortnik <michael.bortnik@innowise.com>; Lizaveta Akulenka <lizaveta.akulenka@innowise.com>
Subject: Re: Follow-up on the Innowise x KIMI-Plus Meeting (26.05.2026)

Good evening Mr. Tausch,

the test cases are good and clear – many thanks! Viktor has reviewed everything. One question about the test cases: For the last scenario "Batch – Overview /kimidev_ET/kimibatch/kimibatchtree.php" – do we need a separate CSV file for that, or is it not necessary?

We successfully downloaded and decoded the dump – thank you!

> I am currently requesting a VPN access to Anexia.

We look forward to the access. Will Anexia take over the current production server settings including the project folder, or will we get an empty server and have to set everything up from scratch?

We have prepared an estimate for the final testing, bugfixing and deployment – the table is attached and also available via link.

The estimate covers two main parts:

1. Test & local debugging – import the dump, test locally and fix any bugs.
2. Deployment to the test server – final deployment.

There is a red-marked bugfixing task. We do not expect major problems, but we would like to point out that some risk remains – especially in batch processing, additional effort could arise.

Best regards

---

## Previous message in thread: Darya → Franz (Jun 8, 2026)

Good day Franz, many thanks for the updates!

We will get back to you with our feedback soon.

Best regards

---

## Previous message in thread: Franz → Darya (Jun 7, 2026)

Dear Ms. Nestserava,

I am sending you a test description of the most important dialog steps and the most important process steps in the batch for client INKO2016 – see attachment.

I will send the DB dump via WeTransfer – password for the ZIP file: $Kimi$Innowise2026

The VPN access is in progress.

Please let me know whether the tests and the DB dump are acceptable.

Thank you and kind regards

Franz Tausch

---

## Previous message in thread: Franz → Darya (Jun 2, 2026)

Dear Ms. Nestserava,

a brief update:

- The DB dump is being prepared by Anexia – I will get in touch regarding delivery as soon as it is ready
- I will create a template for the test description
- I am currently requesting a VPN access to Anexia.

Next status update at the start of next week at the latest.

Have a nice day,

Kind regards

Fran Tausch

---

## Previous message in thread: Franz → Darya (May 28, 2026)

Dear Ms. Nestserava,

thank you from my side as well for the pleasant and constructive meeting.

I have reviewed Viktor's document to the extent I can answer at this stage and added my notes.

My next step is to coordinate with Anexia.

I will keep you informed.

Have a nice day, kind regards

FranZ

---

## Previous message in thread: Darya → Franz (May 27, 2026)

Good day Mr. Tausch, many thanks again for the productive and open conversation!

We really appreciate your time and the helpful insights you shared with us. As discussed, the next steps are as follows:

1. Setup new test environment
2. Deploy the updated PHP 8.5 code base and test database
3. Test & bugfix
4. Final deploy to production
5. Auto-login issue

Viktor has prepared a document describing the ideas. Please take a brief look to check that everything is correct – you are welcome to leave your answers and comments on the open questions directly in the document.

If you have any questions or suggestions about these steps, please get in touch – we are happy to discuss everything again. We always welcome your feedback and are glad to support you at every step!

Have a nice day!

--

Darya Nestserava
Service Delivery Specialist (DACH)
INNOWISE
darya.nestserava@innowise.com
https://innowise.com/
