# Your installation or use of this SugarCRM file is subject to the applicable
# terms available at
# http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
# If you do not agree to all of the applicable terms or do not have the
# authority to bind the entity as an authorized representative, then do not
# install or use this SugarCRM file.
#
# Copyright (C) SugarCRM Inc. All rights reserved.

@loginService @login @logout @local
Feature: Login
  Existed user logged in more than allowed and requested to change password
  Existing user tries to Login and logout
  Existing user tries to Login and logout with logout cookie
  User tries to login into not existing tenant
  User doesn't see tenant if it's pre-filled
  User sees an error in case of invalid tenant hint
  User sees an error in case of inactive tenant hint
  User opens forgot password form
  User tries to set new password
  User should see "Single Sign-On" button when initially logging-in (no tenant is known)
  User should not see "Single Sign-On" button for a tenant with disabled SAML-login option
  User should be able to change language on login page
  Authenticated user should not be able to change language

  Scenario: Existed user logged in more than allowed and requested to change password
    Given I am on "/"
    Then I login as "sally" with password "sally" to tenant "0000000006"
    And I should see "You are logged in as sally"
    Then I do logout
    And I should see "Log In"
    Then I login as "sally" with password "sally" to tenant "0000000006"
    And I should see "Change your password"
    Then I fill in "oldPassword" with "sally"
    And I fill in "newPassword" with "sally"
    And I fill in "confirmPassword" with "sally"
    And I click "#set-new-password-btn"
    And I should see "Change your password"
    And I should see "New password must be different from previous password"
    Then I fill in "oldPassword" with "sally"
    And I fill in "newPassword" with "sally-new-pass"
    And I fill in "confirmPassword" with "sally-new-pass"
    And I click "#set-new-password-btn"
    And I should see "Password changed successful"
    And I click "#set-new-password-btn"
    And I should see "You are logged in as sally"
    Then I do logout
    And I should see "Log In"
    Then I login as "sally" with password "sally-new-pass" to tenant "0000000006"
    And I should see "You are logged in as sally"
    Then I do logout
    And I should see "Log In"

  Scenario: Existing user tries to Login and logout
    Given I am on "/"
    And I login as "sally" with password "sally" to tenant "0000000001"
    Then I should see "You are logged in as sally"
    Then I should see "Your tenant id is srn:cloud:iam:eu:0000000001:tenant"
    Then I should see "Authentication provider - Local"
    And I should see logo with "alt" = "Local Test Tenant"
    And I should see logo with "src" = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMsAAABoCAQAAAD1esz4AAAACXZwQWcAAADLAAAAaADD2bLRAAAFKklEQVR42u3bz4vcZBzH8fljsrZiFSQHwYvk3kOUPXgKUlAKkoqHFsGg2INdRteTl1BRPJR4UFpRxsMKIhjEc0DRSouDeNBLUEQE4e0hv54kT2bj9hk7LR8+l5knM7M731eeX8nugoWye1EJxKKIRSyKWMSiiEURi1gUsYhFEYtYFLEoYhGLIhaxKGIRiyIWRSxiUcQiFkUsJ8kPXOUS53iGF0n5FrHsAMk5vEGe5GvEchfzGWdGKB4eexwglruULzhlRalyiFjuQn7G34Di8QDf8yuX2WefC3zEH4hli7nJh3wKi2c3onh4vMznxjOfDxDLVnLEWTw83uKrY1E8znJ70HIFsTjOPyRteT/m6Rksj/HbqO1txOI0V4ziZuzNYNnj1qjtFN8hFmfJexDPz0DxeJgbltbzYnGX/UHB57A8zlOW1tP8jlic5NYshvEgZm8/EoubZCdimcp7YnGTA6csh2Jxk1ecsrwjFjd50ynLl2Jxk08copzhL7G4SclpZywXtW9xlwuOUB7ktljc5aeZW8jj8q6uibmeX/buGOV1XUF2n+s8dAckj3BN91u2kx85by35E7zBNTIyrvIq4ehm8qNc5hfdndzuzeL3eYmY54i5xCE3uDkq+J8cccALXOQ1rvINf99j9/Xvi78Tu/+iEohFEYtYFLGIRRGLIhaxKGIRiyIWsZwwa1IjK9YMj2W9q7jV67pHKaVxfFW35ZifPH5/yppV/RPNO//jT1xTTF5FLupPKLEfzUjJet+oSd7+ljvKko/ugURtIfL6ufn66jXdI6/HFtRtKeYnd4VZt2056/qfirqjSzw8kgFjZC3eioCQlJQEn2RAUxARsKyPRj2aFJ+YlJQYf3DS7DBLV+p5LCFdqTwry3JQ+IqFRYqHR0xTyoqpnMGS4RvneklCaLwvq38DE6I51RLC3mkSDk6DnWKJ2tLExhk+j6XrDckES8CwN3l1UUPjcYSH1xvUplgKvNHQFre8a/zRpzSEKcGAvSRw2GO2xNIVN57J4re9oWyfmyy+UeyV0ZIb/TGgJLP8rCmW2HKGr9vTI9lw/vuDmbLqW8G9wFLSlH4OyxIPv14CNM9NloiwHahiPEIig6UZ1pb4g3lmE4tnnayj+qwf9xXzu9raPWeT/xZZmuGkYA5L0faGqvzpiKVqKSnrI32W0vh3cNtgMmYpJoqbEjN9dNPyIXI2jP0PLPksloaj4RmzNBwNT5+lWyiEzCtlPskS0T+aGUv/aolxT7MEdQHnsaT1q6rBbMxSDV4BQT2YDVmaib8belJjYTAu5RrPulNZktA/2rFU03o2QR9aZpydY8nb1dN6sI7qtzQsZW8hbGPpFs4rK8uwZTPL1OwRbphbqv5QWEFLy7pu51gKYy3V9Juui8fGhq/rN82iuphgYeHXazAbwrhlTV6ntLIklra8XYktLUej9vuklkXFzq7Egrqzx4NxPm13/tVQYO45OpaV8R47y9LYVh7Pctw0XTJc6JaEbcFLy969OZobG8vuNMx3laWf2OjqycQVAJOl6g3pBpai7U0uWKpidtfO8sFevcAnbhfbBZGxs896pBm+s3lliywByag8OUndT0KWxs7CZFm2o7adhUXY9sD/ytI/KfJ2L19d7YoIGE/ZJSk+IREBweDiZ05cv9Mndny5UhfR656QT1w/buao9eTWMt/C3zeLRLfBFLGIRRGLWBSxKGIRiyIWsShiEYsiFkUsYlHEIhZFLGJRxKKIRSyKWMSiiEVhweJf2dROPUsirO4AAAAASUVORK5CYII="
    Then I do logout
    Then I should see "Log In"
    And I should see logo with "alt" = "SugarCRM"
    And I should see logo with "src" = "/img/company_logo.png"

  Scenario: Existing user tries to Login and logout with logout cookie
    Given I am on "/"
    And I login as "max" with password "max" to tenant "0000000001"
    Then I should see "You are logged in as max"
    Then I do logout
    Then I should see "Log In"
    Then I should see logout cookie
    And I login as "max" with password "max" to tenant "0000000001"
    Then I should not see logout cookie
    Then I do logout

  Scenario: User tries to login into not existing tenant
    Given I am on "/"
    And I login as "sally" with password "sally" to tenant "1000000001"
    Then I should see "Invalid credentials"
    Then I should see "Log In"
    Then I should see logo with "alt" = "SugarCRM"
    Then I should see logo with "src" = "/img/company_logo.png"

  Scenario: User doesn't see tenant if it's pre-filled
    Given I am on "/?tenant_hint=srn:cloud:iam:eu:0000000001:tenant"
    Then I wait for the element "input[name=user_name]"
    Then I should not see "Tenant"
    And I should not see a "#tid" element
    And I should see logo with "alt" = "Local Test Tenant"
    And I should see logo with "src" = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMsAAABoCAQAAAD1esz4AAAACXZwQWcAAADLAAAAaADD2bLRAAAFKklEQVR42u3bz4vcZBzH8fljsrZiFSQHwYvk3kOUPXgKUlAKkoqHFsGg2INdRteTl1BRPJR4UFpRxsMKIhjEc0DRSouDeNBLUEQE4e0hv54kT2bj9hk7LR8+l5knM7M731eeX8nugoWye1EJxKKIRSyKWMSiiEURi1gUsYhFEYtYFLEoYhGLIhaxKGIRiyIWRSxiUcQiFkUsJ8kPXOUS53iGF0n5FrHsAMk5vEGe5GvEchfzGWdGKB4eexwglruULzhlRalyiFjuQn7G34Di8QDf8yuX2WefC3zEH4hli7nJh3wKi2c3onh4vMznxjOfDxDLVnLEWTw83uKrY1E8znJ70HIFsTjOPyRteT/m6Rksj/HbqO1txOI0V4ziZuzNYNnj1qjtFN8hFmfJexDPz0DxeJgbltbzYnGX/UHB57A8zlOW1tP8jlic5NYshvEgZm8/EoubZCdimcp7YnGTA6csh2Jxk1ecsrwjFjd50ynLl2Jxk08copzhL7G4SclpZywXtW9xlwuOUB7ktljc5aeZW8jj8q6uibmeX/buGOV1XUF2n+s8dAckj3BN91u2kx85by35E7zBNTIyrvIq4ehm8qNc5hfdndzuzeL3eYmY54i5xCE3uDkq+J8cccALXOQ1rvINf99j9/Xvi78Tu/+iEohFEYtYFLGIRRGLIhaxKGIRiyIWsZwwa1IjK9YMj2W9q7jV67pHKaVxfFW35ZifPH5/yppV/RPNO//jT1xTTF5FLupPKLEfzUjJet+oSd7+ljvKko/ugURtIfL6ufn66jXdI6/HFtRtKeYnd4VZt2056/qfirqjSzw8kgFjZC3eioCQlJQEn2RAUxARsKyPRj2aFJ+YlJQYf3DS7DBLV+p5LCFdqTwry3JQ+IqFRYqHR0xTyoqpnMGS4RvneklCaLwvq38DE6I51RLC3mkSDk6DnWKJ2tLExhk+j6XrDckES8CwN3l1UUPjcYSH1xvUplgKvNHQFre8a/zRpzSEKcGAvSRw2GO2xNIVN57J4re9oWyfmyy+UeyV0ZIb/TGgJLP8rCmW2HKGr9vTI9lw/vuDmbLqW8G9wFLSlH4OyxIPv14CNM9NloiwHahiPEIig6UZ1pb4g3lmE4tnnayj+qwf9xXzu9raPWeT/xZZmuGkYA5L0faGqvzpiKVqKSnrI32W0vh3cNtgMmYpJoqbEjN9dNPyIXI2jP0PLPksloaj4RmzNBwNT5+lWyiEzCtlPskS0T+aGUv/aolxT7MEdQHnsaT1q6rBbMxSDV4BQT2YDVmaib8belJjYTAu5RrPulNZktA/2rFU03o2QR9aZpydY8nb1dN6sI7qtzQsZW8hbGPpFs4rK8uwZTPL1OwRbphbqv5QWEFLy7pu51gKYy3V9Juui8fGhq/rN82iuphgYeHXazAbwrhlTV6ntLIklra8XYktLUej9vuklkXFzq7Egrqzx4NxPm13/tVQYO45OpaV8R47y9LYVh7Pctw0XTJc6JaEbcFLy969OZobG8vuNMx3laWf2OjqycQVAJOl6g3pBpai7U0uWKpidtfO8sFevcAnbhfbBZGxs896pBm+s3lliywByag8OUndT0KWxs7CZFm2o7adhUXY9sD/ytI/KfJ2L19d7YoIGE/ZJSk+IREBweDiZ05cv9Mndny5UhfR656QT1w/buao9eTWMt/C3zeLRLfBFLGIRRGLWBSxKGIRiyIWsShiEYsiFkUsYlHEIhZFLGJRxKKIRSyKWMSiiEVhweJf2dROPUsirO4AAAAASUVORK5CYII="
    When I fill in "user_name" with "sally"
    When I fill in "password" with "sally"
    Then I click "#submit_btn"
    And I wait for the page to be loaded
    Then I should see "You are logged in as sally"
    Then I should see "Your tenant id is srn:cloud:iam:eu:0000000001:tenant"
    Then I should see "Authentication provider - Local"
    And I should see logo with "alt" = "Local Test Tenant"
    And I should see logo with "src" = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMsAAABoCAQAAAD1esz4AAAACXZwQWcAAADLAAAAaADD2bLRAAAFKklEQVR42u3bz4vcZBzH8fljsrZiFSQHwYvk3kOUPXgKUlAKkoqHFsGg2INdRteTl1BRPJR4UFpRxsMKIhjEc0DRSouDeNBLUEQE4e0hv54kT2bj9hk7LR8+l5knM7M731eeX8nugoWye1EJxKKIRSyKWMSiiEURi1gUsYhFEYtYFLEoYhGLIhaxKGIRiyIWRSxiUcQiFkUsJ8kPXOUS53iGF0n5FrHsAMk5vEGe5GvEchfzGWdGKB4eexwglruULzhlRalyiFjuQn7G34Di8QDf8yuX2WefC3zEH4hli7nJh3wKi2c3onh4vMznxjOfDxDLVnLEWTw83uKrY1E8znJ70HIFsTjOPyRteT/m6Rksj/HbqO1txOI0V4ziZuzNYNnj1qjtFN8hFmfJexDPz0DxeJgbltbzYnGX/UHB57A8zlOW1tP8jlic5NYshvEgZm8/EoubZCdimcp7YnGTA6csh2Jxk1ecsrwjFjd50ynLl2Jxk08copzhL7G4SclpZywXtW9xlwuOUB7ktljc5aeZW8jj8q6uibmeX/buGOV1XUF2n+s8dAckj3BN91u2kx85by35E7zBNTIyrvIq4ehm8qNc5hfdndzuzeL3eYmY54i5xCE3uDkq+J8cccALXOQ1rvINf99j9/Xvi78Tu/+iEohFEYtYFLGIRRGLIhaxKGIRiyIWsZwwa1IjK9YMj2W9q7jV67pHKaVxfFW35ZifPH5/yppV/RPNO//jT1xTTF5FLupPKLEfzUjJet+oSd7+ljvKko/ugURtIfL6ufn66jXdI6/HFtRtKeYnd4VZt2056/qfirqjSzw8kgFjZC3eioCQlJQEn2RAUxARsKyPRj2aFJ+YlJQYf3DS7DBLV+p5LCFdqTwry3JQ+IqFRYqHR0xTyoqpnMGS4RvneklCaLwvq38DE6I51RLC3mkSDk6DnWKJ2tLExhk+j6XrDckES8CwN3l1UUPjcYSH1xvUplgKvNHQFre8a/zRpzSEKcGAvSRw2GO2xNIVN57J4re9oWyfmyy+UeyV0ZIb/TGgJLP8rCmW2HKGr9vTI9lw/vuDmbLqW8G9wFLSlH4OyxIPv14CNM9NloiwHahiPEIig6UZ1pb4g3lmE4tnnayj+qwf9xXzu9raPWeT/xZZmuGkYA5L0faGqvzpiKVqKSnrI32W0vh3cNtgMmYpJoqbEjN9dNPyIXI2jP0PLPksloaj4RmzNBwNT5+lWyiEzCtlPskS0T+aGUv/aolxT7MEdQHnsaT1q6rBbMxSDV4BQT2YDVmaib8belJjYTAu5RrPulNZktA/2rFU03o2QR9aZpydY8nb1dN6sI7qtzQsZW8hbGPpFs4rK8uwZTPL1OwRbphbqv5QWEFLy7pu51gKYy3V9Juui8fGhq/rN82iuphgYeHXazAbwrhlTV6ntLIklra8XYktLUej9vuklkXFzq7Egrqzx4NxPm13/tVQYO45OpaV8R47y9LYVh7Pctw0XTJc6JaEbcFLy969OZobG8vuNMx3laWf2OjqycQVAJOl6g3pBpai7U0uWKpidtfO8sFevcAnbhfbBZGxs896pBm+s3lliywByag8OUndT0KWxs7CZFm2o7adhUXY9sD/ytI/KfJ2L19d7YoIGE/ZJSk+IREBweDiZ05cv9Mndny5UhfR656QT1w/buao9eTWMt/C3zeLRLfBFLGIRRGLWBSxKGIRiyIWsShiEYsiFkUsYlHEIhZFLGJRxKKIRSyKWMSiiEVhweJf2dROPUsirO4AAAAASUVORK5CYII="
    Then I do logout
    Then I should see "Log In"
    And I should see an "input[placeholder=Tenant]" element
    And I should see a "#tid" element
    And I should see logo with "alt" = "SugarCRM"
    And I should see logo with "src" = "/img/company_logo.png"

  Scenario: User sees an error in case of invalid tenant hint
    Given I am on "/?tenant_hint=INVALID_TENANT_ID"
    Then I should see a "#tid" element
    And I should see "Tenant not found"

  Scenario: User sees an error in case of inactive tenant hint
    Given I am on "/?tenant_hint=0000000007"
    Then I should see a "#tid" element
    And I should see "Tenant isn't active"

  Scenario: User opens forgot password form
    Given I am on "/password/forgot?tid=0000000001"
    And I wait for the element "input[name=user_name]"
    And I should see logo with "alt" = "Local Test Tenant"
    And I should see logo with "src" = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMsAAABoCAQAAAD1esz4AAAACXZwQWcAAADLAAAAaADD2bLRAAAFKklEQVR42u3bz4vcZBzH8fljsrZiFSQHwYvk3kOUPXgKUlAKkoqHFsGg2INdRteTl1BRPJR4UFpRxsMKIhjEc0DRSouDeNBLUEQE4e0hv54kT2bj9hk7LR8+l5knM7M731eeX8nugoWye1EJxKKIRSyKWMSiiEURi1gUsYhFEYtYFLEoYhGLIhaxKGIRiyIWRSxiUcQiFkUsJ8kPXOUS53iGF0n5FrHsAMk5vEGe5GvEchfzGWdGKB4eexwglruULzhlRalyiFjuQn7G34Di8QDf8yuX2WefC3zEH4hli7nJh3wKi2c3onh4vMznxjOfDxDLVnLEWTw83uKrY1E8znJ70HIFsTjOPyRteT/m6Rksj/HbqO1txOI0V4ziZuzNYNnj1qjtFN8hFmfJexDPz0DxeJgbltbzYnGX/UHB57A8zlOW1tP8jlic5NYshvEgZm8/EoubZCdimcp7YnGTA6csh2Jxk1ecsrwjFjd50ynLl2Jxk08copzhL7G4SclpZywXtW9xlwuOUB7ktljc5aeZW8jj8q6uibmeX/buGOV1XUF2n+s8dAckj3BN91u2kx85by35E7zBNTIyrvIq4ehm8qNc5hfdndzuzeL3eYmY54i5xCE3uDkq+J8cccALXOQ1rvINf99j9/Xvi78Tu/+iEohFEYtYFLGIRRGLIhaxKGIRiyIWsZwwa1IjK9YMj2W9q7jV67pHKaVxfFW35ZifPH5/yppV/RPNO//jT1xTTF5FLupPKLEfzUjJet+oSd7+ljvKko/ugURtIfL6ufn66jXdI6/HFtRtKeYnd4VZt2056/qfirqjSzw8kgFjZC3eioCQlJQEn2RAUxARsKyPRj2aFJ+YlJQYf3DS7DBLV+p5LCFdqTwry3JQ+IqFRYqHR0xTyoqpnMGS4RvneklCaLwvq38DE6I51RLC3mkSDk6DnWKJ2tLExhk+j6XrDckES8CwN3l1UUPjcYSH1xvUplgKvNHQFre8a/zRpzSEKcGAvSRw2GO2xNIVN57J4re9oWyfmyy+UeyV0ZIb/TGgJLP8rCmW2HKGr9vTI9lw/vuDmbLqW8G9wFLSlH4OyxIPv14CNM9NloiwHahiPEIig6UZ1pb4g3lmE4tnnayj+qwf9xXzu9raPWeT/xZZmuGkYA5L0faGqvzpiKVqKSnrI32W0vh3cNtgMmYpJoqbEjN9dNPyIXI2jP0PLPksloaj4RmzNBwNT5+lWyiEzCtlPskS0T+aGUv/aolxT7MEdQHnsaT1q6rBbMxSDV4BQT2YDVmaib8belJjYTAu5RrPulNZktA/2rFU03o2QR9aZpydY8nb1dN6sI7qtzQsZW8hbGPpFs4rK8uwZTPL1OwRbphbqv5QWEFLy7pu51gKYy3V9Juui8fGhq/rN82iuphgYeHXazAbwrhlTV6ntLIklra8XYktLUej9vuklkXFzq7Egrqzx4NxPm13/tVQYO45OpaV8R47y9LYVh7Pctw0XTJc6JaEbcFLy969OZobG8vuNMx3laWf2OjqycQVAJOl6g3pBpai7U0uWKpidtfO8sFevcAnbhfbBZGxs896pBm+s3lliywByag8OUndT0KWxs7CZFm2o7adhUXY9sD/ytI/KfJ2L19d7YoIGE/ZJSk+IREBweDiZ05cv9Mndny5UhfR656QT1w/buao9eTWMt/C3zeLRLfBFLGIRRGLWBSxKGIRiyIWsShiEYsiFkUsYlHEIhZFLGJRxKKIRSyKWMSiiEVhweJf2dROPUsirO4AAAAASUVORK5CYII="
    And I wait for the element "#forgot-recaptcha"
    And I wait for the element "textarea[name=g-recaptcha-response]"
    And I wait for the element "input[name=first_name]"

  Scenario: User tries to set new password
    Given I am on "/password/set/?tid=0000000001&token=validToken"
    And I wait for the element "input[name=newPassword]"
    Then I should see "Please choose a new password"
    And I should see logo with "alt" = "Local Test Tenant"
    And I should see logo with "src" = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMsAAABoCAQAAAD1esz4AAAACXZwQWcAAADLAAAAaADD2bLRAAAFKklEQVR42u3bz4vcZBzH8fljsrZiFSQHwYvk3kOUPXgKUlAKkoqHFsGg2INdRteTl1BRPJR4UFpRxsMKIhjEc0DRSouDeNBLUEQE4e0hv54kT2bj9hk7LR8+l5knM7M731eeX8nugoWye1EJxKKIRSyKWMSiiEURi1gUsYhFEYtYFLEoYhGLIhaxKGIRiyIWRSxiUcQiFkUsJ8kPXOUS53iGF0n5FrHsAMk5vEGe5GvEchfzGWdGKB4eexwglruULzhlRalyiFjuQn7G34Di8QDf8yuX2WefC3zEH4hli7nJh3wKi2c3onh4vMznxjOfDxDLVnLEWTw83uKrY1E8znJ70HIFsTjOPyRteT/m6Rksj/HbqO1txOI0V4ziZuzNYNnj1qjtFN8hFmfJexDPz0DxeJgbltbzYnGX/UHB57A8zlOW1tP8jlic5NYshvEgZm8/EoubZCdimcp7YnGTA6csh2Jxk1ecsrwjFjd50ynLl2Jxk08copzhL7G4SclpZywXtW9xlwuOUB7ktljc5aeZW8jj8q6uibmeX/buGOV1XUF2n+s8dAckj3BN91u2kx85by35E7zBNTIyrvIq4ehm8qNc5hfdndzuzeL3eYmY54i5xCE3uDkq+J8cccALXOQ1rvINf99j9/Xvi78Tu/+iEohFEYtYFLGIRRGLIhaxKGIRiyIWsZwwa1IjK9YMj2W9q7jV67pHKaVxfFW35ZifPH5/yppV/RPNO//jT1xTTF5FLupPKLEfzUjJet+oSd7+ljvKko/ugURtIfL6ufn66jXdI6/HFtRtKeYnd4VZt2056/qfirqjSzw8kgFjZC3eioCQlJQEn2RAUxARsKyPRj2aFJ+YlJQYf3DS7DBLV+p5LCFdqTwry3JQ+IqFRYqHR0xTyoqpnMGS4RvneklCaLwvq38DE6I51RLC3mkSDk6DnWKJ2tLExhk+j6XrDckES8CwN3l1UUPjcYSH1xvUplgKvNHQFre8a/zRpzSEKcGAvSRw2GO2xNIVN57J4re9oWyfmyy+UeyV0ZIb/TGgJLP8rCmW2HKGr9vTI9lw/vuDmbLqW8G9wFLSlH4OyxIPv14CNM9NloiwHahiPEIig6UZ1pb4g3lmE4tnnayj+qwf9xXzu9raPWeT/xZZmuGkYA5L0faGqvzpiKVqKSnrI32W0vh3cNtgMmYpJoqbEjN9dNPyIXI2jP0PLPksloaj4RmzNBwNT5+lWyiEzCtlPskS0T+aGUv/aolxT7MEdQHnsaT1q6rBbMxSDV4BQT2YDVmaib8belJjYTAu5RrPulNZktA/2rFU03o2QR9aZpydY8nb1dN6sI7qtzQsZW8hbGPpFs4rK8uwZTPL1OwRbphbqv5QWEFLy7pu51gKYy3V9Juui8fGhq/rN82iuphgYeHXazAbwrhlTV6ntLIklra8XYktLUej9vuklkXFzq7Egrqzx4NxPm13/tVQYO45OpaV8R47y9LYVh7Pctw0XTJc6JaEbcFLy969OZobG8vuNMx3laWf2OjqycQVAJOl6g3pBpai7U0uWKpidtfO8sFevcAnbhfbBZGxs896pBm+s3lliywByag8OUndT0KWxs7CZFm2o7adhUXY9sD/ytI/KfJ2L19d7YoIGE/ZJSk+IREBweDiZ05cv9Mndny5UhfR656QT1w/buao9eTWMt/C3zeLRLfBFLGIRRGLWBSxKGIRiyIWsShiEYsiFkUsYlHEIhZFLGJRxKKIRSyKWMSiiEVhweJf2dROPUsirO4AAAAASUVORK5CYII="
    When I fill in "newPassword" with "Sarah321!"
    When I fill in "confirmPassword" with "Sarah321!"
    Then I click "#submit_btn"
    Then I should see "Password reset successful"
    And I should see logo with "alt" = "Local Test Tenant"
    And I should see logo with "src" = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMsAAABoCAQAAAD1esz4AAAACXZwQWcAAADLAAAAaADD2bLRAAAFKklEQVR42u3bz4vcZBzH8fljsrZiFSQHwYvk3kOUPXgKUlAKkoqHFsGg2INdRteTl1BRPJR4UFpRxsMKIhjEc0DRSouDeNBLUEQE4e0hv54kT2bj9hk7LR8+l5knM7M731eeX8nugoWye1EJxKKIRSyKWMSiiEURi1gUsYhFEYtYFLEoYhGLIhaxKGIRiyIWRSxiUcQiFkUsJ8kPXOUS53iGF0n5FrHsAMk5vEGe5GvEchfzGWdGKB4eexwglruULzhlRalyiFjuQn7G34Di8QDf8yuX2WefC3zEH4hli7nJh3wKi2c3onh4vMznxjOfDxDLVnLEWTw83uKrY1E8znJ70HIFsTjOPyRteT/m6Rksj/HbqO1txOI0V4ziZuzNYNnj1qjtFN8hFmfJexDPz0DxeJgbltbzYnGX/UHB57A8zlOW1tP8jlic5NYshvEgZm8/EoubZCdimcp7YnGTA6csh2Jxk1ecsrwjFjd50ynLl2Jxk08copzhL7G4SclpZywXtW9xlwuOUB7ktljc5aeZW8jj8q6uibmeX/buGOV1XUF2n+s8dAckj3BN91u2kx85by35E7zBNTIyrvIq4ehm8qNc5hfdndzuzeL3eYmY54i5xCE3uDkq+J8cccALXOQ1rvINf99j9/Xvi78Tu/+iEohFEYtYFLGIRRGLIhaxKGIRiyIWsZwwa1IjK9YMj2W9q7jV67pHKaVxfFW35ZifPH5/yppV/RPNO//jT1xTTF5FLupPKLEfzUjJet+oSd7+ljvKko/ugURtIfL6ufn66jXdI6/HFtRtKeYnd4VZt2056/qfirqjSzw8kgFjZC3eioCQlJQEn2RAUxARsKyPRj2aFJ+YlJQYf3DS7DBLV+p5LCFdqTwry3JQ+IqFRYqHR0xTyoqpnMGS4RvneklCaLwvq38DE6I51RLC3mkSDk6DnWKJ2tLExhk+j6XrDckES8CwN3l1UUPjcYSH1xvUplgKvNHQFre8a/zRpzSEKcGAvSRw2GO2xNIVN57J4re9oWyfmyy+UeyV0ZIb/TGgJLP8rCmW2HKGr9vTI9lw/vuDmbLqW8G9wFLSlH4OyxIPv14CNM9NloiwHahiPEIig6UZ1pb4g3lmE4tnnayj+qwf9xXzu9raPWeT/xZZmuGkYA5L0faGqvzpiKVqKSnrI32W0vh3cNtgMmYpJoqbEjN9dNPyIXI2jP0PLPksloaj4RmzNBwNT5+lWyiEzCtlPskS0T+aGUv/aolxT7MEdQHnsaT1q6rBbMxSDV4BQT2YDVmaib8belJjYTAu5RrPulNZktA/2rFU03o2QR9aZpydY8nb1dN6sI7qtzQsZW8hbGPpFs4rK8uwZTPL1OwRbphbqv5QWEFLy7pu51gKYy3V9Juui8fGhq/rN82iuphgYeHXazAbwrhlTV6ntLIklra8XYktLUej9vuklkXFzq7Egrqzx4NxPm13/tVQYO45OpaV8R47y9LYVh7Pctw0XTJc6JaEbcFLy969OZobG8vuNMx3laWf2OjqycQVAJOl6g3pBpai7U0uWKpidtfO8sFevcAnbhfbBZGxs896pBm+s3lliywByag8OUndT0KWxs7CZFm2o7adhUXY9sD/ytI/KfJ2L19d7YoIGE/ZJSk+IREBweDiZ05cv9Mndny5UhfR656QT1w/buao9eTWMt/C3zeLRLfBFLGIRRGLWBSxKGIRiyIWsShiEYsiFkUsYlHEIhZFLGJRxKKIRSyKWMSiiEVhweJf2dROPUsirO4AAAAASUVORK5CYII="
    And I click "#login_link"
    Then I wait for the element "input[name=user_name]"
    When I fill in "user_name" with "sarah"
    When I fill in "password" with "Sarah321!"
    Then I should see logo with "alt" = "Local Test Tenant"
    Then I should see logo with "src" = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMsAAABoCAQAAAD1esz4AAAACXZwQWcAAADLAAAAaADD2bLRAAAFKklEQVR42u3bz4vcZBzH8fljsrZiFSQHwYvk3kOUPXgKUlAKkoqHFsGg2INdRteTl1BRPJR4UFpRxsMKIhjEc0DRSouDeNBLUEQE4e0hv54kT2bj9hk7LR8+l5knM7M731eeX8nugoWye1EJxKKIRSyKWMSiiEURi1gUsYhFEYtYFLEoYhGLIhaxKGIRiyIWRSxiUcQiFkUsJ8kPXOUS53iGF0n5FrHsAMk5vEGe5GvEchfzGWdGKB4eexwglruULzhlRalyiFjuQn7G34Di8QDf8yuX2WefC3zEH4hli7nJh3wKi2c3onh4vMznxjOfDxDLVnLEWTw83uKrY1E8znJ70HIFsTjOPyRteT/m6Rksj/HbqO1txOI0V4ziZuzNYNnj1qjtFN8hFmfJexDPz0DxeJgbltbzYnGX/UHB57A8zlOW1tP8jlic5NYshvEgZm8/EoubZCdimcp7YnGTA6csh2Jxk1ecsrwjFjd50ynLl2Jxk08copzhL7G4SclpZywXtW9xlwuOUB7ktljc5aeZW8jj8q6uibmeX/buGOV1XUF2n+s8dAckj3BN91u2kx85by35E7zBNTIyrvIq4ehm8qNc5hfdndzuzeL3eYmY54i5xCE3uDkq+J8cccALXOQ1rvINf99j9/Xvi78Tu/+iEohFEYtYFLGIRRGLIhaxKGIRiyIWsZwwa1IjK9YMj2W9q7jV67pHKaVxfFW35ZifPH5/yppV/RPNO//jT1xTTF5FLupPKLEfzUjJet+oSd7+ljvKko/ugURtIfL6ufn66jXdI6/HFtRtKeYnd4VZt2056/qfirqjSzw8kgFjZC3eioCQlJQEn2RAUxARsKyPRj2aFJ+YlJQYf3DS7DBLV+p5LCFdqTwry3JQ+IqFRYqHR0xTyoqpnMGS4RvneklCaLwvq38DE6I51RLC3mkSDk6DnWKJ2tLExhk+j6XrDckES8CwN3l1UUPjcYSH1xvUplgKvNHQFre8a/zRpzSEKcGAvSRw2GO2xNIVN57J4re9oWyfmyy+UeyV0ZIb/TGgJLP8rCmW2HKGr9vTI9lw/vuDmbLqW8G9wFLSlH4OyxIPv14CNM9NloiwHahiPEIig6UZ1pb4g3lmE4tnnayj+qwf9xXzu9raPWeT/xZZmuGkYA5L0faGqvzpiKVqKSnrI32W0vh3cNtgMmYpJoqbEjN9dNPyIXI2jP0PLPksloaj4RmzNBwNT5+lWyiEzCtlPskS0T+aGUv/aolxT7MEdQHnsaT1q6rBbMxSDV4BQT2YDVmaib8belJjYTAu5RrPulNZktA/2rFU03o2QR9aZpydY8nb1dN6sI7qtzQsZW8hbGPpFs4rK8uwZTPL1OwRbphbqv5QWEFLy7pu51gKYy3V9Juui8fGhq/rN82iuphgYeHXazAbwrhlTV6ntLIklra8XYktLUej9vuklkXFzq7Egrqzx4NxPm13/tVQYO45OpaV8R47y9LYVh7Pctw0XTJc6JaEbcFLy969OZobG8vuNMx3laWf2OjqycQVAJOl6g3pBpai7U0uWKpidtfO8sFevcAnbhfbBZGxs896pBm+s3lliywByag8OUndT0KWxs7CZFm2o7adhUXY9sD/ytI/KfJ2L19d7YoIGE/ZJSk+IREBweDiZ05cv9Mndny5UhfR656QT1w/buao9eTWMt/C3zeLRLfBFLGIRRGLWBSxKGIRiyIWsShiEYsiFkUsYlHEIhZFLGJRxKKIRSyKWMSiiEVhweJf2dROPUsirO4AAAAASUVORK5CYII="
    Then I click "#submit_btn"
    And I wait for the page to be loaded
    Then I should see "You are logged in as sarah"
    Then I should see "Your tenant id is srn:cloud:iam:eu:0000000001:tenant"
    Then I should see "Authentication provider - Local"
    And I should see logo with "alt" = "Local Test Tenant"
    And I should see logo with "src" = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMsAAABoCAQAAAD1esz4AAAACXZwQWcAAADLAAAAaADD2bLRAAAFKklEQVR42u3bz4vcZBzH8fljsrZiFSQHwYvk3kOUPXgKUlAKkoqHFsGg2INdRteTl1BRPJR4UFpRxsMKIhjEc0DRSouDeNBLUEQE4e0hv54kT2bj9hk7LR8+l5knM7M731eeX8nugoWye1EJxKKIRSyKWMSiiEURi1gUsYhFEYtYFLEoYhGLIhaxKGIRiyIWRSxiUcQiFkUsJ8kPXOUS53iGF0n5FrHsAMk5vEGe5GvEchfzGWdGKB4eexwglruULzhlRalyiFjuQn7G34Di8QDf8yuX2WefC3zEH4hli7nJh3wKi2c3onh4vMznxjOfDxDLVnLEWTw83uKrY1E8znJ70HIFsTjOPyRteT/m6Rksj/HbqO1txOI0V4ziZuzNYNnj1qjtFN8hFmfJexDPz0DxeJgbltbzYnGX/UHB57A8zlOW1tP8jlic5NYshvEgZm8/EoubZCdimcp7YnGTA6csh2Jxk1ecsrwjFjd50ynLl2Jxk08copzhL7G4SclpZywXtW9xlwuOUB7ktljc5aeZW8jj8q6uibmeX/buGOV1XUF2n+s8dAckj3BN91u2kx85by35E7zBNTIyrvIq4ehm8qNc5hfdndzuzeL3eYmY54i5xCE3uDkq+J8cccALXOQ1rvINf99j9/Xvi78Tu/+iEohFEYtYFLGIRRGLIhaxKGIRiyIWsZwwa1IjK9YMj2W9q7jV67pHKaVxfFW35ZifPH5/yppV/RPNO//jT1xTTF5FLupPKLEfzUjJet+oSd7+ljvKko/ugURtIfL6ufn66jXdI6/HFtRtKeYnd4VZt2056/qfirqjSzw8kgFjZC3eioCQlJQEn2RAUxARsKyPRj2aFJ+YlJQYf3DS7DBLV+p5LCFdqTwry3JQ+IqFRYqHR0xTyoqpnMGS4RvneklCaLwvq38DE6I51RLC3mkSDk6DnWKJ2tLExhk+j6XrDckES8CwN3l1UUPjcYSH1xvUplgKvNHQFre8a/zRpzSEKcGAvSRw2GO2xNIVN57J4re9oWyfmyy+UeyV0ZIb/TGgJLP8rCmW2HKGr9vTI9lw/vuDmbLqW8G9wFLSlH4OyxIPv14CNM9NloiwHahiPEIig6UZ1pb4g3lmE4tnnayj+qwf9xXzu9raPWeT/xZZmuGkYA5L0faGqvzpiKVqKSnrI32W0vh3cNtgMmYpJoqbEjN9dNPyIXI2jP0PLPksloaj4RmzNBwNT5+lWyiEzCtlPskS0T+aGUv/aolxT7MEdQHnsaT1q6rBbMxSDV4BQT2YDVmaib8belJjYTAu5RrPulNZktA/2rFU03o2QR9aZpydY8nb1dN6sI7qtzQsZW8hbGPpFs4rK8uwZTPL1OwRbphbqv5QWEFLy7pu51gKYy3V9Juui8fGhq/rN82iuphgYeHXazAbwrhlTV6ntLIklra8XYktLUej9vuklkXFzq7Egrqzx4NxPm13/tVQYO45OpaV8R47y9LYVh7Pctw0XTJc6JaEbcFLy969OZobG8vuNMx3laWf2OjqycQVAJOl6g3pBpai7U0uWKpidtfO8sFevcAnbhfbBZGxs896pBm+s3lliywByag8OUndT0KWxs7CZFm2o7adhUXY9sD/ytI/KfJ2L19d7YoIGE/ZJSk+IREBweDiZ05cv9Mndny5UhfR656QT1w/buao9eTWMt/C3zeLRLfBFLGIRRGLWBSxKGIRiyIWsShiEYsiFkUsYlHEIhZFLGJRxKKIRSyKWMSiiEVhweJf2dROPUsirO4AAAAASUVORK5CYII="
    Then I do logout

  Scenario: Existing user should find "Single Sign-On" button when logging in unspecified tenant
    Given I am on "/"
    And I wait for the element "a[id=submit_btn]"
    And I should see "Single Sign-On"

  Scenario: Existing user should not find "Single Sign-On" button when logging in tenant with no SAML configured
    Given I am on "/?tenant_hint=srn:cloud:iam:eu:0000000001:tenant"
    And I wait for the element "a[id=submit_btn]"
    And I should not see "Single Sign-On"

  Scenario: User should be able to change language on login page
    Given I am on "/"
    And I wait for the element "a[id=submit_btn]"
    Then I should see "Language / Sprache / Idioma"
    And I click "#languageList"
    Then I should see "English (US)"
    Then I should see "Deutsch"
    And I follow "Deutsch"
    Then I should see "DE Log In"

  Scenario: Authenticated user should not be able to change language
    Given I am on "/"
    And I login as "sally" with password "sally" to tenant "0000000001"
    Then I should see "You are logged in as sally"
    Then I should not see "Language / Sprache / Idioma"
    Then I do logout
