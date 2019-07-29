#!/usr/bin/env bash

# Your installation or use of this SugarCRM file is subject to the applicable
# terms available at
# http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
# If you do not agree to all of the applicable terms or do not have the
# authority to bind the entity as an authorized representative, then do not
# install or use this SugarCRM file.
#
# Copyright (C) SugarCRM Inc. All rights reserved.

while :
do
    case "$1" in
        -f)
            IDM_FOLDER="$2"
            shift 2
            ;;
        *)
            break
            ;;
    esac
done

if [[ -z ${IDM_FOLDER} ]]
then
    printf "Please set up IdM folder for mapping in container: -f /var/www/IdentityProvider \n\n"
    exit
fi

HYDRA_POD=`kubectl get pods --namespace=iam | grep hydra | awk {'print $1'}`
OIDC_HYDRA_CLIENT_ID=`kubectl --namespace=iam get secret oidc-client-iam -o yaml | grep CLIENT_ID | sed -e 's/^[ \t]*//' | cut -d' ' -f2 | base64 --decode`
OIDC_HYDRA_CLIENT_PASSWORD=`kubectl --namespace=iam get secret oidc-client-iam -o yaml | grep CLIENT_SECRET | sed -e 's/^[ \t]*//' | cut -d' ' -f2 | base64 --decode`

printf "HYDRA POD: ${HYDRA_POD}\n"
printf "HYDRA ID: ${OIDC_HYDRA_CLIENT_ID}\n"
printf "HYDRA PASSWORD: ${OIDC_HYDRA_CLIENT_PASSWORD}\n"

if [[ -z ${OIDC_HYDRA_CLIENT_ID} ]] || [[ -z ${OIDC_HYDRA_CLIENT_PASSWORD} ]] || [[ -z ${HYDRA_POD} ]]
then
    printf "Please deploy iam operator first \n\n"
    exit
fi

if [[ -n `kubectl get ns | grep idm-ns-localhost` ]];
then
    printf "Please undeploy namespace idm-ns-localhost first \n\n"
    exit 1
fi

IDP_POD=`kubectl --namespace=iam get pods | grep idp | grep -v service | awk '{ print $1; }'`
kubectl --namespace=iam exec ${IDP_POD} -- sed -e 's/%%IamNS%%/idm-ns-localhost/g' ./tests/behat/db/fixtures.sql -i
kubectl --namespace=iam exec ${IDP_POD} -- ./bin/console fixtures:load

echo "test@example.com" | kubectl --namespace=iam exec -it ${HYDRA_POD} -- /go/bin/hydra connect --id=${OIDC_HYDRA_CLIENT_ID} --secret=${OIDC_HYDRA_CLIENT_PASSWORD} --url=http://localhost:4444

if ! kubectl --namespace=iam exec ${HYDRA_POD} -- /go/bin/hydra clients get srn:cloud:iam:eu:0000000001:app:crm:99711b76-bb31-11e8-8df0-985aeb8a5c2a ;
then
    kubectl --namespace=iam exec -i ${HYDRA_POD} -- /go/bin/hydra clients create --skip-tls-verify --id srn:cloud:iam:eu:0000000001:app:crm:99711b76-bb31-11e8-8df0-985aeb8a5c2a --name srn:cloud:iam:eu:0000000001:app:crm:99711b76-bb31-11e8-8df0-985aeb8a5c2a --secret mangoOIDCClientSecret --grant-types authorization_code,refresh_token,client_credentials,implicit,urn:ietf:params:oauth:grant-type:jwt-bearer --response-types token,code,id_token --allowed-scopes openid,offline,hydra.keys.get,hydra,https://apis.sugarcrm.com/auth/iam.password,idp.auth.password,https://apis.sugarcrm.com/auth/crm,profile,email,address,phone  --callbacks "http://login.sugarcrm.local/consumer,http://localhost/consumer,http://behat-tests-mango-oidc.idm-ns-localhost/?module=Users&action=OAuth2CodeExchange"
fi

if ! kubectl --namespace=iam exec ${HYDRA_POD} -- /go/bin/hydra clients get srn:cloud:iam:eu:0000000001:app:native:806bfb76-ee57-43ea-9022-aa91e6b6c617 ;
then
    kubectl --namespace=iam exec -i ${HYDRA_POD} -- /go/bin/hydra clients create --skip-tls-verify --id srn:cloud:iam:eu:0000000001:app:native:806bfb76-ee57-43ea-9022-aa91e6b6c617 --name srn:cloud:iam:eu:0000000001:app:native:806bfb76-ee57-43ea-9022-aa91e6b6c617 --secret NativeOIDCClientSecret --grant-types authorization_code,refresh_token,client_credentials,implicit,urn:ietf:params:oauth:grant-type:jwt-bearer --response-types token,code,id_token --allowed-scopes openid,offline,hydra.keys.get,hydra,https://apis.sugarcrm.com/auth/iam.password,idp.auth.password,https://apis.sugarcrm.com/auth/crm,profile,email,address,phone  --callbacks "http://login.sugarcrm.local/consumer,http://localhost/consumer,http://behat-tests-mango-oidc.idm-ns-localhost/?module=Users&action=OAuth2CodeExchange"
fi

if ! kubectl --namespace=iam exec ${HYDRA_POD} -- /go/bin/hydra keys get mangoOIDCKeySet ;
then
    kubectl --namespace=iam exec ${HYDRA_POD} -- /go/bin/hydra keys create mangoOIDCKeySet -a RS256
    kubectl --namespace=iam exec ${HYDRA_POD} -- /go/bin/hydra policies create --skip-tls-verify --actions get --allow --id mangoOIDCKeySet --resources "rn:hydra:keys:mangoOIDCKeySet:private" --subjects "srn:cloud:iam:eu:0000000001:app:crm:99711b76-bb31-11e8-8df0-985aeb8a5c2a"
    kubectl --namespace=iam exec ${HYDRA_POD} -- /go/bin/hydra policies create --skip-tls-verify --actions get --allow --id mangoOIDCKeySet --resources "rn:hydra:keys:mangoOIDCKeySet:public" --subjects "srn:cloud:iam:eu:0000000001:app:crm:99711b76-bb31-11e8-8df0-985aeb8a5c2a"

    kubectl --namespace=iam exec ${HYDRA_POD} -- /go/bin/hydra policies create --skip-tls-verify --actions get --allow --id mangoOIDCKeySet --resources "rn:hydra:keys:hydra.consent.response:private" --subjects "srn:cloud:iam:eu:0000000001:app:crm:99711b76-bb31-11e8-8df0-985aeb8a5c2a"
    kubectl --namespace=iam exec ${HYDRA_POD} -- /go/bin/hydra policies create --skip-tls-verify --actions get --allow --id mangoOIDCKeySet --resources "rn:hydra:keys:hydra.consent.response:public" --subjects "srn:cloud:iam:eu:0000000001:app:crm:99711b76-bb31-11e8-8df0-985aeb8a5c2a"
    kubectl --namespace=iam exec ${HYDRA_POD} -- /go/bin/hydra policies create --skip-tls-verify --actions get --allow --id mangoOIDCKeySet --resources "rn:hydra:keys:hydra.consent.challenge:public" --subjects "srn:cloud:iam:eu:0000000001:app:crm:99711b76-bb31-11e8-8df0-985aeb8a5c2a"
fi

# Retry to create network. Kubernetes can lag after previous ./undeploy.sh.
for i in {1..5};
do
  kubectl create namespace idm-ns-localhost && break
  sleep 30
done

kubectl --namespace idm-ns-localhost create -f ./selenium-service.yaml
kubectl --namespace idm-ns-localhost create -f ./selenium-deployment.yaml
kubectl --namespace idm-ns-localhost create -f ./selenium-ingress.yaml

cat idm-pod.yaml.template | sed -e "s~%%IDM_FOLDER%%~${IDM_FOLDER}~g" > idm-pod.yaml
kubectl --namespace idm-ns-localhost create -f ./idm-pod.yaml
rm idm-pod.yaml

kubectl --namespace idm-ns-localhost create -f ./ldap-service.yaml
kubectl --namespace idm-ns-localhost create -f ./ldap-deployment.yaml

kubectl --namespace idm-ns-localhost create -f ./saml-service.yaml
kubectl --namespace idm-ns-localhost create -f ./saml-deployment.yaml
kubectl --namespace idm-ns-localhost create -f ./saml-ingress.yaml

kubectl --namespace idm-ns-localhost create -f ./mango/base-services.yaml
kubectl --namespace idm-ns-localhost create -f ./mango/base-deployment.yaml
kubectl --namespace idm-ns-localhost create -f ./mango/base-ingresses.yaml

kubectl --namespace idm-ns-localhost create -f ./mango/oidc-service.yaml
kubectl --namespace idm-ns-localhost create -f ./mango/oidc-deployment.yaml
kubectl --namespace idm-ns-localhost create -f ./mango/oidc-ingress.yaml

kubectl --namespace idm-ns-localhost create configmap mango-config --from-file=./mango/config/

kubectl --namespace idm-ns-localhost create -f ./mango/saml-base-service.yaml
kubectl --namespace idm-ns-localhost create -f ./mango/saml-base-deployment.yaml
kubectl --namespace idm-ns-localhost create -f ./mango/saml-base-ingress.yaml

kubectl --namespace idm-ns-localhost create -f ./mango/saml-same-window-service.yaml
kubectl --namespace idm-ns-localhost create -f ./mango/saml-same-window-deployment.yaml
kubectl --namespace idm-ns-localhost create -f ./mango/saml-same-window-ingress.yaml

kubectl --namespace idm-ns-localhost create -f ./mango/saml-same-window-no-user-provision-service.yaml
kubectl --namespace idm-ns-localhost create -f ./mango/saml-same-window-no-user-provision-deployment.yaml
kubectl --namespace idm-ns-localhost create -f ./mango/saml-same-window-no-user-provision-ingress.yaml
