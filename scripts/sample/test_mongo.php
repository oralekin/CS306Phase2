<?php
// Example file showing MongoDB connection using the native PHP MongoDB driver

// Connect to MongoDB
try {
    // Create MongoDB client
    $manager = new MongoDB\Driver\Manager("mongodb://" . $_ENV['MONGO_ROOT_USERNAME']. ":" . $_ENV['MONGO_ROOT_PASSWORD']."@mongodb:27017");
    
    // Create a document to insert
    $document = [
        'name' => 'Test Document',
        'date' => new MongoDB\BSON\UTCDateTime(time() * 1000)
    ];
    
    // Create bulk write object and add our insert operation
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->insert($document);
    
    // Execute the insert

    $result = $manager->executeBulkWrite('app.app', $bulk);
    
    echo "Successfully connected to MongoDB and inserted a document!";
    
    // Query to verify our insert
    $query = new MongoDB\Driver\Query([]);
    $cursor = $manager->executeQuery('app.app', $query);
    
    echo "<pre>Documents in collection:<br>";
    foreach ($cursor as $document) {
        print_r($document);
    }
    echo "</pre>";
    
} catch (Exception $e) {
    echo "Error connecting to MongoDB: " . $e->getMessage();
}
