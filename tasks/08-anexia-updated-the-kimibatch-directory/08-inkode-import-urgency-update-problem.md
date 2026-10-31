# INKODE import — the INFO field is not written

The problem is in the batch import **"IMPORT INKODE-Daten"**, the script `kimibatch/inkodeimp2.php`.

## Steps to reproduce

> Running the import writes to the database — it imports the tickets from the current INKODE input file. Only run it when an import is actually intended.


2. Open `https://10.196.69.21/kimidev_ET/login.php` in the browser. The dev server uses a self-signed certificate, so the browser asks to confirm a security exception the first time — confirm it.
3. Enter the user name and the password and press **Login**.
4. Choose any client in **MANDANTENAUSWAHL** and press **Auswählen**.
5. Open the batch overview `https://10.196.69.21/kimidev_ET/kimibatch/kimibatchtree.php`.
6. Click the arrow in front of the branch **INKODE** to open it.
7. Click **IMPORT INKODE-Daten**. The import starts and prints its steps on the page as it runs.
8. Wait until the page stops producing new lines, then scroll down to the step headed **INKODE IMPORT - update ticket join inkourgenz**.
9. Read the line directly below that step. **Expected:** `UPDATE TICKET URGENZ durchgeführt`. **Actual:** `UPDATE TICKET URGENZ: Data too long for column 'dummy_text10' at row 1`.
10. Scroll to the bottom of the page. The import finishes normally, with the sections **Prüfung URGENZ** and **Prüfung OFFENE EINGESPIELT** and the closing line **INKODE IMPORT - Ende** and its timestamp.
11. To see the effect on the data, open the Ticketsuche for the INKODE client, open a ticket belonging to a debtor who has several cases, and look at the green **INFO** field on the ticket screen. It still shows the text from before the import: the summary of that debtor's other cases has not been written.

## What has to be changed to fix the problem permanently

The column `dummy_text10` of the table `ticket` must be changed from `varchar(4000)` NULL to `text` NULL, keeping the character set `utf8mb3` and the collation `utf8mb3_general_ci`.

```sql
ALTER TABLE `ticket`
  MODIFY `dummy_text10` text
  CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL;
```

To be executed on both databases.
