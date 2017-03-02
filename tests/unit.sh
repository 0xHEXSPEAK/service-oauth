#!/usr/bin/env bash

TESTS_PATH=`dirname $0`
cd ${TESTS_PATH}

../vendor/bin/codecept run unit $*