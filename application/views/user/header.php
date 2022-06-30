<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>EMPATHY : ACCOUNT</title>
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/app.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/bundles/ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/components.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/bundles/datatables/datatables.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/custom.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/bundles/jquery-selectric/selectric.css">
  <link rel='shortcut icon' type='image/x-icon' href='<?php echo base_url();?>assets/img/favicon.ico' />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script>
 
      // JavaScript implementation to count pairs
      // in a binary tree whose sum is
      // equal to the given value x
      // structure of a node of a binary tree
      class Node {
        constructor() {
          this.data = 0;
          this.left = null;
          this.right = null;
        }
      }
 
      var head_ref = null;
 
      // function to create and return a node
      // of a binary tree
      function getNode(data) {
        // allocate space for the node
        var new_node = new Node();
 
        // put in the data
        new_node.data = data;
        new_node.left = new_node.right = null;
        return new_node;
      }
 
      // A simple recursive function to convert
      // a given Binary tree to Doubly Linked List
      // root -. Root of Binary Tree
      // head_ref -. Pointer to head node of
      // created doubly linked list
      function BToDLL(root) {
        // Base cases
        if (root == null) return;
 
        // Recursively convert right subtree
        BToDLL(root.right);
 
        // insert root into DLL
        root.right = head_ref;
 
        // Change left pointer of previous head
        if (head_ref != null) head_ref.left = root;
 
        // Change head of Doubly linked list
        head_ref = root;
 
        // Recursively convert left subtree
        BToDLL(root.left);
      }
 
      // Split a doubly linked list (DLL)
      // into 2 DLLs of half sizes
      function split(head) {
        var fast = head,
          slow = head;
        while (fast.right != null && fast.right.right != null) {
          fast = fast.right.right;
          slow = slow.right;
        }
        var temp = slow.right;
        slow.right = null;
        return temp;
      }
 
      // Function to merge two sorted
      // doubly linked lists
      function merge(first, second) {
        // If first linked list is empty
        if (first == null) return second;
 
        // If second linked list is empty
        if (second == null) return first;
 
        // Pick the smaller value
        if (first.data < second.data) {
          first.right = merge(first.right, second);
          first.right.left = first;
          first.left = null;
          return first;
        } else {
          second.right = merge(first, second.right);
          second.right.left = second;
          second.left = null;
          return second;
        }
      }
 
      function mergeSort(head) {
        if (head == null || head.right == null) return head;
        var second = split(head);
 
        head = mergeSort(head);
        second = mergeSort(second);
 
        return merge(head, second);
      }
 

      function pairSum(head, x) {

        var first = head;
        var second = head;
        while (second.right != null) second = second.right;
 
        var count = 0;
 
        while (
          first != null &&
          second != null &&
          first != second &&
          second.right != first
        ) {
          if (first.data + second.data == x) {
            count++;
 
            first = first.right;
 
            second = second.left;
          } else {
            if (first.data + second.data < x) first = first.right;
            else second = second.left;
          }
        }
        return count;
      }
 
      // function to count pairs in a binary tree
      // whose sum is equal to given value x
      function countPairs(root, x) {
        head_ref = null;
 
        // Convert binary tree to
        // doubly linked list
        BToDLL(root);
 
        // sort DLL
        head_ref = mergeSort(head_ref);
 
        // count pairs
        return pairSum(head_ref, x);
      }
 
      // Driver Code
      // formation of binary tree
      var root = getNode(5); /* 5 */
      root.left = getNode(3); /* / \ */
      root.right = getNode(7); /* 3 7 */
      root.left.left = getNode(2); /* / \ / \ */
      root.left.left.left = getNode(9); /* / \ / \ */
      root.left.left.right = getNode(10); /* / \ / \ */
      root.left.right = getNode(4); /* 2 4 6 8 */
      root.right.left = getNode(6);
      root.right.right = getNode(8);
 
      var x = 10;
 
      console.log("Count = " + countPairs(root, x));
    </script>
</head>