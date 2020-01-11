.PHONY: check-style check-style-ci
.PHONY: check-cpd check-cpd-ci
.PHONY: check-js check-js-ci
.PHONY: check-all-ci
 
# Both these command exit non-0 when any violations occur
# We want to ignore that so we can get all the results in jenkins
.IGNORE: check-style-ci check-cpd-ci
 
check-style:
	phpcs --standard=Laravel --extensions=php,ctp -p ./src
 
check-style-ci:
	phpcs --standard=Laravel \
		--extensions=php,ctp -p --report=checkstyle \
		--report-file=build/checkstyle.xml ./src
 
check-cpd:
	phpcpd --min-lines 3 --min-tokens 50 --suffixes php ./src
 
check-cpd-ci:
	phpcpd --min-lines 3 --min-tokens 50 \
		--suffixes php --log-pmd build/pmd.xml ./src
 
# check-js:
#	jshint webroot/javascript --config app/Config/jshint.json
 
# check-all-ci: check-style-ci check-cpd-ci check-js
check-all-ci: check-style-ci check-cpd-ci