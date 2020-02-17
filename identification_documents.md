### Requirements
there are no strict deadlines, but lets keep in touch - if you have any problems or have no free time available for the task, just contact us at team-2@paysera.lt;
task should be implemented using Symfony framework, LTS version (currently 3.4);
task should be done using Symfony components (e.g. validator, dependency injection, console);
third party libraries, dependencies, tools etc. can be used if seems necessary, 3rd party code should be added with composer dependency manager;
code should run in Docker container;
your system must be maintainable:
clear dependencies between separate parts of your code;
system must be both testable and tested (unit tests are required);
code understandable, readable, have a clear flow;
your system must be extensible:
adding new functionality or changing existing one should not require rewriting the system itself or it's core parts;
code must be PSR-1 and PSR-12 compatible;
minimal documentation should be provided:
how environment should be set up, (what Docker command to run);
how system should be ran (what command to run);
how to initiate system's tests (what command to run);
short description of functionality in more difficult places could be provided in the code itself;
do not use external infrastructure dependencies, like MySQL databases or temporary files - just make the calculations in memory;
do not use Paysera name in titles, descriptions or the code itself. This helps others to find the libraries that are really related to our services and/or are developed and maintained by our team.

### Task

#### Situation
Paysera users can go to a branch to perform identification. Several identification document types of multiple countries are supported with different requirements to each of them.

### Document validation rules

#### Basic rules
We support passport, identity card and residence permit documents in all countries. Provided document should not be expired (all documents expire 5 years after issue), must have a valid number (all documents have document number consisting of 8 symbols) and should be issued on workday (Monday to Friday). Moreover, due to high demand, single client may only attempt two identification request per 5 working days. Identification system must also take into account country-specific document requirements.

### German (de) document rules
As of 2010-01-01 Germany started to issue new type of identity card, which expires after 10 years.

### Spanish (es) document rules
As of 2013-02-14 Spain started to issue new type of passport, which expires after 15 years. Also, Spanish authorities report, that passports, containing serial numbers from 50001111 to 50009999 where stolen and no longer may be used for client identification.

### French (fr) document rules
Bank of Lithuania decided, that French clients may also be identified with French drivers licence (any issue date).

### Polish (pl) document rules
Bank of Lithuania decided, than Polish clients may also be identified with residence permits, issued after 2015-06-01. Also, Polish government, starting 2018-09-01, began to issue new identity cards, which have document number length of 10 symbols.

### Italian (it) document rules
Italian government decided, that starting from 2019-01-01 document office will be working overtime on Saturdays until 2019-01-31 to cope with increased demand of identity document issue requests.

### United Kingdom (uk) document rules
Due to UK leaving european union, after 2019-01-01 only passports will be accepted as proof of identity from UK clients.

### Input data
Input data is given in CSV file. Identification requests are given in that file. In each line following data is provided:

identification request date in format Y-m-d
identity document country code
identity document type
identity document number
identity document issue date in format Y-m-d
identity document owner's personal identification number
###Expected Result
As a single argument program must accept a path to the input file.

Program must output result to stdout.

Result - string with identification request's status ("valid" or error code) for each identification request.


### Error codes
document_type_is_invalid - document type is not supported
document_is_expired - document is expired
document_number_length_invalid - document number length is invalid
document_number_invalid - document with this number cannot be used for identification
document_issue_date_invalid - document issued on non-working day
request_limit_exceeded - limit of identification attempts is exceeded

### Example Data
➜  cat input.csv 
2019-01-01,lt,passport,30122719,2019-03-01,357717289
2019-01-01,pl,identity_card,9879386836,2018-11-01,643023760
2019-01-02,lt,passport,46530663,2019-03-01,357717289
2019-01-02,pl,identity_card,4531480055,2017-10-21,324444899
2019-01-03,lt,passport,54163812,2019-03-01,357717289
2019-01-03,fr,drivers_license,95180604,2018-07-02,942959784
2019-01-03,de,identity_card,14253292,2009-01-01,962044284
2019-01-03,fr,residence_permit,50016230,2019-04-01,141994836
2019-01-04,uk,identity_card,64053869,2015-09-07,840252118
2019-01-04,es,passport,17728070,2013-03-01,772226409
2019-01-04,pl,residence_permit,56934120,2016-08-01,643023760
2019-01-04,es,passport,50008532,2015-09-08,320962200
2019-01-04,it,residence_permit,97316275,2019-01-05,621736871
2019-02-15,it,passport,30810814,2019-02-16,415855641
➜  php bin/console identification-requests:process input.csv
valid
valid
valid
document_number_length_invalid
request_limit_exceeded
valid
document_is_expired
valid
document_type_invalid
valid
valid
document_number_invalid
valid
document_issue_date_invalid

### Evaluation Criteria
all requirements must be met;
code quality - it's maintainability, extensibility, testability; speed of the system can also be considered, but is not as important as other criteria.

### Task Submission
You can put the code publicly (in github or similar code control systems) if you want, but please note the requirement about Paysera name usage.

Send it in your favourite format (link to versioned code, code in zip file etc.) to team-2@paysera.lt.