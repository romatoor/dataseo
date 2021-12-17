
#signature

dataseo:domain_intersection {targets} {exclude_targets?}';

{targets} - domains, subdomains or webpages to get links for
            required field
            you can set up to 20 domains, subdomains or webpages
            a domain or a subdomain should be specified without https:// and www.
            a page should be specified with absolute URL (including http:// or https://)
            
{exclude_targets?} - domains, subdomains or webpages you want to exclude
                     optional field
                     you can specify up to 10 domains, subdomains or webpages
                     if you use this array, results will contain the referring domains that link to targets but don’t link to exclude_targets         

#description
This endpoint will provide you with the list of domains pointing to the specified websites.
    
#example    
    
php artisan dataseo:domain_intersection expressvpn.com,nordvpn.com protonvpn.com

